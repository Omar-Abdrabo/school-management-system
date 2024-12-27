<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MyParent extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['father_name', 'mother_name', 'father_job', 'mother_job'];
    protected $table = 'my_parents';
    protected $guarded = [];

    public function parrentAttachments()
    {
        return $this->hasMany(ParentAttachment::class, 'parent_id');
    }
}
