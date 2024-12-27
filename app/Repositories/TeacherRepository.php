<?php

namespace App\Repositories;

use App\Models\Gender;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Specialization;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\TeacherRepositoryInterface;

class TeacherRepository implements TeacherRepositoryInterface
{
    /**
     * Get all teachers.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllTeachers()
    {
        return Teacher::all();
    }

    /**
     * Get a teacher by their ID.
     *
     * @param int $id The ID of the teacher to retrieve.
     * @return \App\Models\Teacher|null The teacher model, or null if not found.
     */
    public function getTeacherById($id)
    {
        return Teacher::find($id);
    }
    /**
     * Store a new teacher in the database.
     *
     * @param \Illuminate\Http\Request $request The request containing the teacher data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the teachers index page on success, or back to the previous page with errors on failure.
     *
     * @throws \Exception If an error occurs while saving the teacher.
     */
    public function storeTeacher($request)
    {
        try {
            $teacher = new Teacher();
            $teacher->email = $request->email;
            $teacher->password = Hash::make($request->password);
            $teacher->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $teacher->gender_id = $request->gender_id;
            $teacher->specialization_id = $request->specialization_id;
            $teacher->joining_date = $request->joining_date;
            $teacher->address = $request->address;
            $teacher->save();
            // Teacher::create($request);
            toastr()->success(trans('messages.success'));
            return redirect()->route('teachers.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function editTeacher($id)
    {
        return Teacher::findOrFail($id);
    }
    /**
     * Update a new teacher in the database.
     *
     * @param \Illuminate\Http\Request $request The request containing the teacher data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the teachers index page on success, or back to the previous page with errors on failure.
     *
     * @throws \Exception If an error occurs while saving the teacher.
     */
    public function updateTeacher($request)
    {
        try {
            $teacher = Teacher::findOrFail($request->id);
            $teacher->email = $request->email;
            if (isset($request->password) && !empty($request->password)) {
                $teacher->password = Hash::make($request->password);
            }
            $teacher->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $teacher->gender_id = $request->gender_id;
            $teacher->specialization_id = $request->specialization_id;
            $teacher->joining_date = $request->joining_date;
            $teacher->address = $request->address;
            $teacher->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teachers.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function deleteTeacher($id)
    {
        $this->getTeacherById($id)->delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->route('teachers.index');
    }

    public function getGender()
    {
        return Gender::all();
    }

    public function getSpecialization()
    {
        return Specialization::all();
    }
}
