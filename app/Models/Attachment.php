<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'path', 'filed_name','caption', 'extention','size','attachmentable_type','attachmentable_id', 'type'];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
