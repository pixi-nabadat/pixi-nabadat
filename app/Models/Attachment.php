<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public static $types = [
        "image" => ['jpg', 'jpeg', 'gif', 'png'],
        "pdf" => ['application/pdf'],
        "docx" => ['application/octet-stream'],
        "3DS" => ['application/3DS'],
        "zip" => ['application/x-zip-compressed'],
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
