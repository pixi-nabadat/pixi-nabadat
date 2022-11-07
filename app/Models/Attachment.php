<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'path', 'caption', 'extention','size','attachmentable_type','attachmentable_id'];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
