<?php

namespace App\Models;


use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasTranslations;
    use SoftDeletes;



    public $translatable = ['name'];
    protected $guarded = [];


    /**
     * Get the attachments associated with the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function myParent()
    {
        return $this->belongsTo(MyParent::class, 'parent_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function studentAccountent()
    {
        return $this->hasMany(StudentAccountent::class, 'student_id');
    }

    public function studentAttendance()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }
    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }
}
