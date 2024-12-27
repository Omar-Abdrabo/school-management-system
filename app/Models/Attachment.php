<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['file_name', 'attachmentable_type', 'attachmentable_id'];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
