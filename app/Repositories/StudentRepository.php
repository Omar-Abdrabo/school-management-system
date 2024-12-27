<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Gender;
use App\Models\Section;
use App\Models\Student;
use App\Models\MyParent;
use App\Models\BloodType;
use App\Models\Classroom;
use App\Models\Attachment;
use App\Models\Nationality;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentRepositoryInterface
{

    public function getAllStudents()
    {
        return Student::all();
    }

    /**
     * Retrieves the necessary data to display the create student form.
     *
     * This method fetches the required data from the database, such as grades, parents, genders, nationalities, and blood types, and returns a view with this data to be used in the create student form.
     *
     * @return \Illuminate\Contracts\View\View The view with the necessary data to display the create student form.
     */
    public function createStudent()
    {
        $data['grades'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['genders'] = Gender::all();
        $data['nationalities'] = Nationality::all();
        $data['blood_types'] = BloodType::all();
        return view('pages.students.add', $data);
    }

    /**
     * Stores a new student record in the database.
     *
     * This method creates a new student record in the database using the data provided in the $request parameter.
     * It sets the student's name, email, password, gender, nationality, blood type, grade, classroom, section, parent,
     * academic year, and date of birth. If the operation is successful, it displays a success message using the toastr
     * library and redirects the user to the students index page. If an exception occurs, it redirects the user back to
     * the previous page with the error message.
     *
     * @param \Illuminate\Http\Request $request The request object containing the student data.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the students index page or the previous page.
     */
    public function storeStudent($request)
    {

        DB::beginTransaction();

        try {
            $student = new Student();
            $student->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->gender_id = $request->gender_id;
            $student->nationality_id = $request->nationality_id;
            $student->blood_type_id = $request->blood_type_id;
            $student->grade_id = $request->grade_id;
            $student->classroom_id = $request->classroom_id;
            $student->section_id = $request->section_id;
            $student->parent_id = $request->parent_id;
            $student->academic_year = $request->academic_year;
            $student->date_birth = $request->date_birth;
            $student->save();

            // Upload attachments If Exist
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    // Database Insert
                    Attachment::create([
                        'file_name' => $photo->getClientOriginalName(),
                        'attachmentable_type' => 'App\Models\Student',
                        'attachmentable_id' => $student->id,
                    ]);

                    // File Upload
                    $photo->storeAs('/attachments/student_attachment/' . $student->id, $photo->getClientOriginalName(), $disk = 'upload_attachments');
                }
            }

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        $student = new Student();
        return;
    }

    /**
     * Retrieves the necessary data to display the edit form for a student.
     *
     * @param \App\Models\Student $student The student to be edited.
     * @return \Illuminate\Contracts\View\View The view with the necessary data to display the edit form.
     */
    public function editStudent($student)
    {
        $data['grades'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['genders'] = Gender::all();
        $data['nationalities'] = Nationality::all();
        $data['blood_types'] = BloodType::all();
        $data['student'] = $student;
        return view('pages.students.edit', $data);
    }

    public function updateStudent($request)
    {

        try {

            $student = Student::findOrFail($request->id);
            $student->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $student->email = $request->email;
            if (isset($request->password)) {
                $student->password = Hash::make($request->password);
            }
            $student->gender_id = $request->gender_id;
            $student->nationality_id = $request->nationality_id;
            $student->blood_type_id = $request->blood_type_id;
            $student->grade_id = $request->grade_id;
            $student->classroom_id = $request->classroom_id;
            $student->section_id = $request->section_id;
            $student->parent_id = $request->parent_id;
            $student->academic_year = $request->academic_year;
            $student->date_birth = $request->date_birth;
            $student->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showStudent($id)
    {
        $data['student'] = Student::findOrFail($id);

        return view('pages.students.show', $data);
    }

    public function deleteStudent($student)
    {
        $stud = Student::findOrFail($student->id);
        if ($stud->attachments()->count() > 0) {
            Storage::disk('upload_attachments')->deleteDirectory('attachments/student_attachment/' . $stud->id);
            $stud->attachments()->delete();
        }
        $stud->forceDelete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('students.index');
    }

    public function getClassrooms($id)
    {
        //  Classroom::where('grade_id', $id)->pluck('name_class', 'id')
        $list_classes = Grade::find($id)->classrooms()->pluck('name_class', 'id');
        return $list_classes;
    }

    public function getSections($id)
    {
        $grade =  Classroom::find($id)->grade()->pluck('id');
        $list_sections = Classroom::find($id)->sections()->where('grade_id', $grade)->pluck('section_name', 'id');
        return $list_sections;
    }

    public function upload_attachment($request)
    {
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'mimes:pdf,jpeg,png,jpg'
        ]);

        foreach ($request->file('photos') as $photo) {
            Attachment::create([
                'file_name' => $photo->getClientOriginalName(),
                'attachmentable_type' => 'App\Models\Student',
                'attachmentable_id' => $request->student_id,
            ]);
            $photo->storeAs('/attachments/student_attachment/' . $request->student_id, $photo->getClientOriginalName(), $disk = 'upload_attachments');
            toastr()->success(trans('messages.success'));
            return redirect()->route('students.show', $request->student_id);
        }
    }

    public function download_attachment($student_id, $file_name)
    {
        return response()->download(public_path('storage/attachments/student_attachment/' . $student_id . '/' . $file_name));
    }

    public function delete_attachment($request)
    {
        Storage::disk('upload_attachments')->delete('attachments/student_attachment/' . $request->student_id . '/' . $request->file_name);
        Attachment::where('attachmentable_id', $request->student_id)->where('file_name', $request->file_name)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('students.show', $request->student_id);
    }
}
