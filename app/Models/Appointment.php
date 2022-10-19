<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory,Filterable;
    public const WEEKDAYS = [
        0 =>['en'=>'All The Days',  'ar'=>'كل ايام الاسبوع'],
        1 =>['en'=>'Saturday',      'ar'=>'السبت'],
        2 =>['en'=>'Sunday',        'ar'=>'الأحد '],
        3 =>['en'=>'Monday',        'ar'=>'الاثنين'],
        4 =>['en'=>'Tuesday',       'ar'=>'الثلاثاء'],
        5 =>['en'=>'Wednesday',     'ar'=>'الأربعاء'],
        6 =>['en'=>'Thursday',      'ar'=>'الخميس '],
        7 =>['en'=>'Friday',        'ar'=>'الجمعة']
    ];
    protected $fillable = ['from','to','appointmentable_id','appointmentable_type','day'];

}
