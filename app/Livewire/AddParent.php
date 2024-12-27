<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MyParent;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\Nationality;
use Livewire\WithFileUploads;
use App\Models\ParentAttachment;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class AddParent extends Component
{
    use WithFileUploads;
    public $successMessage = '';
    public $currentStep = 1;
    public $catchError;
    public $show_table = true;
    public $updateMode = false;
    public $parent_id;
    // Father Data
    public $email, $password, $id;
    public $father_name, $father_name_en, $father_job_en, $father_national_id, $father_passport_id, $father_phone, $father_job,
        $father_address, $religion_father_id, $blood_type_father_id, $nationality_father_id;
    // Mother Data
    public $mother_name, $mother_name_en, $mother_national_id, $mother_passport_id, $mother_phone, $mother_job, $mother_job_en,
        $mother_address, $religion_mother_id, $blood_type_mother_id, $nationality_mother_id;
    //attachments
    public $photos = [];

    /**
     * Validates the specified property names against the defined validation rules.
     *
     * This method is used to validate individual properties as they are updated,
     * ensuring that the input data meets the required criteria.
     *
     * @param string $propertyName The name of the property to validate.
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'email' => 'required|email',
            'father_national_id' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'father_passport_id' => 'min:10|max:10 ',
            'father_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'mother_national_id' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'mother_passport_id' => 'min:10|max:10',
            'mother_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            // 'photos' => ['required', 'extensions:jpg,png'] //|max:1024
        ]);
    }

    /**
     * Renders the view for the AddParent Livewire component.
     *
     * This method is responsible for returning the view that will be rendered for the
     * AddParent Livewire component. It retrieves the necessary data from the database,
     * such as nationalities, blood types, and religions, and passes them to the view.
     *
     * @return \Illuminate\View\View The view to be rendered for the AddParent component.
     */
    public function render()
    {
        return view('livewire.add-parent', [
            'nationalities' => Nationality::all(),
            'blood_types' => BloodType::all(),
            'religions' => Religion::all(),
            'my_parents' => MyParent::all(),
        ]);
    }

    /**
     * Shows the form for adding a new parent.
     *
     * This method is responsible for hiding the table view and displaying the form
     * for adding a new parent.
     */
    public function showAddForm()
    {
        $this->show_table = false;
    }

    /**
     * Shows the table view for parents.
     *
     * This method is responsible for displaying the table view that shows the list of
     * parents in the system. It sets the `show_table` property to `true` to indicate
     * that the table view should be shown.
     */
    public function showParentsTable()
    {
        $this->show_table = true;
    }


    /**
     * Validates the form data for the first step of the parent registration process.
     *
     * This method is responsible for validating the user input for the first step of the
     * parent registration form. It checks the validity of the email, password, father's
     * personal information, and other related fields.
     *
     * If the validation passes, the current step is updated to the next step in the
     * registration process.
     */
    public function firstStepSubmit()
    {
        $this->validate([
            'email' => 'required|unique:my_parents,email,' . $this->id,
            'password' => 'required',
            'father_name' => 'required',
            'father_name_en' => 'required',
            'father_national_id' => 'required|unique:my_parents,father_national_id,', // . $this->id,
            'father_passport_id' => 'required|unique:my_parents,father_passport_id,', //. $this->id,
            'father_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'father_job' => 'required',
            'father_job_en' => 'required',
            'father_address' => 'required',
            'religion_father_id' => 'required',
            'blood_type_father_id' => 'required',
            'nationality_father_id' => 'required',
        ]);
        $this->currentStep = 2;
    }

    /**
     * Validates the form data for the second step of the parent registration process.
     *
     * This method is responsible for validating the user input for the second step of the
     * parent registration form. It checks the validity of the mother's personal information,
     * including name, national ID, passport ID, phone, job, address, religion, blood type,
     * and nationality.
     *
     * If the validation passes, the current step is updated to the next step in the
     * registration process.
     */
    public function secondStepSubmit()
    {
        $this->validate([
            'email' => 'required|unique:my_parents,email,', // . $this->id,
            'password' => 'required',
            'mother_name' => 'required',
            'mother_name_en' => 'required',
            'mother_national_id' => 'required|unique:my_parents,mother_national_id,', // . $this->id,
            'mother_passport_id' => 'required|unique:my_parents,mother_passport_id,', // . $this->id,
            'mother_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'mother_job' => 'required',
            'mother_job_en' => 'required',
            'mother_address' => 'required',
            'religion_mother_id' => 'required',
            'blood_type_mother_id' => 'required',
            'nationality_mother_id' => 'required',
        ]);
        $this->currentStep = 3;
    }




    /**
     * Submits the parent registration form and saves the parent data to the database.
     *
     * This method is responsible for validating the user input for the entire parent
     * registration form, including the parent's personal information, father's
     * information, and mother's information. If the validation passes, the parent
     * data is saved to the database using the MyParent model.
     *
     * If the save operation is successful, the success message is set, the form is
     * cleared, and the current step is reset to the first step. If an exception
     * occurs during the save operation, the error message is set.
     */
    public function submitForm()
    {
        try {
            $my_parent = new MyParent();
            $my_parent->email = $this->email;
            $my_parent->password = Hash::make($this->password);

            $my_parent->father_name = ['en' => $this->father_name_en, 'ar' => $this->father_name];
            $my_parent->father_national_id = $this->father_national_id;
            $my_parent->father_passport_id = $this->father_passport_id;
            $my_parent->father_phone = $this->father_phone;
            $my_parent->father_job = ['en' => $this->father_job_en, 'ar' => $this->father_job];
            $my_parent->father_address = $this->father_address;
            $my_parent->religion_father_id = $this->religion_father_id;
            $my_parent->blood_type_father_id = $this->blood_type_father_id;
            $my_parent->nationality_father_id = $this->nationality_father_id;

            $my_parent->mother_name = ['en' => $this->mother_name_en, 'ar' => $this->mother_name];
            $my_parent->mother_national_id = $this->mother_national_id;
            $my_parent->mother_passport_id = $this->mother_passport_id;
            $my_parent->mother_phone = $this->mother_phone;
            $my_parent->mother_job = ['en' => $this->mother_job_en, 'ar' => $this->mother_job];
            $my_parent->mother_address = $this->mother_address;
            $my_parent->religion_mother_id = $this->religion_mother_id;
            $my_parent->blood_type_mother_id = $this->blood_type_mother_id;
            $my_parent->nationality_mother_id = $this->nationality_mother_id;

            $my_parent->save();

            if ($this->photos) {
                $this->validate([
                    'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                foreach ($this->photos as $photo) {
                    $photo->storeAs($this->father_national_id, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    $my_parent->parrentAttachments()->create([
                        'file_name' => $photo->getClientOriginalName(),
                        'parent_id' => $my_parent->id,
                    ]);
                }
            }
            $this->successMessage = trans('messages.success');
            $this->clearForm();
            $this->currentStep = 1;
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        };
    }

    /**
     * Clears the form data for the parent registration.
     * This method resets all the form fields, including the parent's personal information,
     * father's information, and mother's information, as well as the current step in the
     * registration process.
     */
    public function clearForm()
    {
        $this->email = '';
        $this->password = '';

        $this->father_name = '';
        $this->father_name_en = '';
        $this->father_national_id = '';
        $this->father_passport_id = '';
        $this->father_phone = '';
        $this->father_job = '';
        $this->father_job_en = '';
        $this->father_address = '';
        $this->religion_father_id = '';
        $this->blood_type_father_id = '';
        $this->nationality_father_id = '';

        $this->mother_name = '';
        $this->mother_name_en = '';
        $this->mother_national_id = '';
        $this->mother_passport_id = '';
        $this->mother_phone = '';
        $this->mother_job = '';
        $this->mother_job_en = '';
        $this->mother_address = '';
        $this->religion_mother_id = '';
        $this->blood_type_mother_id = '';
        $this->nationality_mother_id = '';
        $this->currentStep = 1;

        $this->resetErrorBag();
        $this->resetValidation();
        // $this->reset();
    }


    /**
     * Populates the form fields with the data of the specified parent.
     *
     * This method is used to edit an existing parent record. It retrieves the parent data
     * from the database based on the provided `$id` parameter, and then sets the corresponding
     * form fields with the retrieved data.
     *
     * @param int $id The ID of the parent to be edited.
     */
    public function edit($id)
    {
        $this->updateMode = true;
        $my_parent = MyParent::findOrfail($id);
        $this->parent_id = $id;
        $this->email = $my_parent->email;
        $this->password = $my_parent->password;
        $this->father_name = $my_parent->getTranslation('father_name', 'ar');
        $this->father_name_en = $my_parent->getTranslation('father_name', 'en');
        $this->father_job = $my_parent->getTranslation('father_job', 'ar');;
        $this->father_job_en = $my_parent->getTranslation('father_job', 'en');
        $this->father_national_id = $my_parent->father_national_id;
        $this->father_passport_id = $my_parent->father_passport_id;
        $this->father_phone = $my_parent->father_phone;
        $this->nationality_father_id = $my_parent->nationality_father_id;
        $this->blood_type_father_id = $my_parent->blood_type_father_id;
        $this->father_address = $my_parent->father_address;
        $this->religion_father_id = $my_parent->religion_father_id;

        $this->mother_name = $my_parent->getTranslation('mother_name', 'ar');
        $this->mother_name_en = $my_parent->getTranslation('mother_name', 'en');
        $this->mother_job = $my_parent->getTranslation('mother_job', 'ar');;
        $this->mother_job_en = $my_parent->getTranslation('mother_job', 'en');
        $this->mother_national_id = $my_parent->mother_national_id;
        $this->mother_passport_id = $my_parent->mother_passport_id;
        $this->mother_phone = $my_parent->mother_phone;
        $this->nationality_mother_id = $my_parent->nationality_mother_id;
        $this->blood_type_mother_id = $my_parent->blood_type_mother_id;
        $this->mother_address = $my_parent->mother_address;
        $this->religion_mother_id = $my_parent->religion_mother_id;

        $this->show_table = false;
    }

    //firstStepSubmit
    /**
     * Navigates to the second step of the parent registration process.
     *
     * This method is called when the user submits the first step of the parent registration form.
     * It sets the `$updateMode` property to `true` to indicate that the user is editing an existing
     * parent record, and it sets the `$currentStep` property to `2` to move the user to the second
     * step of the registration process.
     */
    public function firstStepSubmit_edit()
    {
        $this->validate([
            'email' => 'required|unique:my_parents,email,' . $this->parent_id,
            'password' => 'nullable|min:8',
            'father_name' => 'required',
            'father_name_en' => 'required',
            'father_national_id' => 'required|unique:my_parents,father_national_id,' . $this->parent_id,
            'father_passport_id' => 'required|unique:my_parents,father_passport_id,' . $this->parent_id,
            'father_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'father_job' => 'required',
            'father_job_en' => 'required',
            'father_address' => 'required',
            'religion_father_id' => 'required',
            'blood_type_father_id' => 'required',
            'nationality_father_id' => 'required',
        ]);
        $this->updateMode = true;
        $this->currentStep = 2;
    }

    //secondStepSubmit_edit
    /**
     * Navigates to the third step of the parent registration process.
     *
     * This method is called when the user submits the second step of the parent registration form.
     * It sets the `$updateMode` property to `true` to indicate that the user is editing an existing
     * parent record, and it sets the `$currentStep` property to `3` to move the user to the third
     * step of the registration process.
     */
    public function secondStepSubmit_edit()
    {
        $this->validate([
            'email' => 'required|unique:my_parents,email,' . $this->parent_id,
            'password' => 'nullable|min:8',
            'mother_name' => 'required',
            'mother_name_en' => 'required',
            'mother_national_id' => 'required|unique:my_parents,mother_national_id,' . $this->parent_id,
            'mother_passport_id' => 'required|unique:my_parents,mother_passport_id,' . $this->parent_id,
            'mother_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'mother_job' => 'required',
            'mother_job_en' => 'required',
            'mother_address' => 'required',
            'religion_mother_id' => 'required',
            'blood_type_mother_id' => 'required',
            'nationality_mother_id' => 'required',
        ]);
        $this->updateMode = true;
        $this->currentStep = 3;
    }

    /**
     * Submits the parent registration form and updates the parent record.
     *
     * This method is called when the user submits the parent registration form in edit mode.
     * It first checks if a parent ID is set, indicating that the user is editing an existing
     * parent record. If so, it finds the parent record using the ID and updates the
     * `father_passport_id` and `father_national_id` fields with the values from the form.
     * Finally, it redirects the user to the `/add_parent` route.
     */
    public function submitForm_edit()
    {
        $my_parent = MyParent::find($this->parent_id);
        if($my_parent->password != $this->password)
        {
            $my_parent->update([
                'password' => Hash::make($this->password),
            ]);
        }
        $my_parent->update([
            'email' => $this->email,
            'father_name' => ['en' => $this->father_name_en, 'ar' => $this->father_name],
            'father_job' => ['en' => $this->father_job_en, 'ar' => $this->father_job],
            'father_phone' => $this->father_phone,
            'father_address' => $this->father_address,
            'father_passport_id' => $this->father_passport_id,
            'father_national_id' => $this->father_national_id,
            'religion_father_id' => $this->religion_father_id,
            'blood_type_father_id' => $this->blood_type_father_id,
            'nationality_father_id' => $this->nationality_father_id,

            'mother_name' => ['en' => $this->mother_name_en, 'ar' => $this->mother_name],
            'mother_job' => ['en' => $this->mother_job_en, 'ar' => $this->mother_job],
            'mother_phone' => $this->mother_phone,
            'mother_address' => $this->mother_address,
            'mother_national_id' => $this->mother_national_id,
            'mother_passport_id' => $this->mother_passport_id,
            'religion_mother_id' => $this->religion_mother_id,
            'blood_type_mother_id' => $this->blood_type_mother_id,
            'nationality_mother_id' => $this->nationality_mother_id,

        ]);
        toastr()->success(trans('messages.Update'));
        return redirect()->to(url(Config::get('app.locale') . ('/add_parent')));
    }

    /**
     * Deletes a parent record from the database.
     *
     * @param int $id The ID of the parent record to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the '/add_parent' route.
     */
    public function delete($id)
    {
        $my_parent = MyParent::findOrFail($id);
        if ($my_parent->parrentAttachments()->count() > 0) {
            Storage::disk('parent_attachments')->deleteDirectory($my_parent->father_national_id);
        }
        MyParent::findOrFail($id)->delete();
        return redirect()->to(url(Config::get('app.locale') . ('/add_parent')));
    }

    /**
     * Navigates to the specified step in the parent registration process.
     *
     * @param int $step The step number to navigate to.
     */
    public function back($step)
    {
        $this->currentStep = $step;
    }
}
