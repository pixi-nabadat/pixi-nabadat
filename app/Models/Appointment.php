<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Appointment extends Model
{
    use HasFactory,Filterable,HasTranslations,EscapeUnicodeJson;
    public const WEEKDAYS = [
        ['day_of_week'=>0,'en'=>'Sunday',        'ar'=>'الأحد '],
        ['day_of_week'=>1,'en'=>'Monday',        'ar'=>'الاثنين'],
        ['day_of_week'=>2,'en'=>'Tuesday',       'ar'=>'الثلاثاء'],
        ['day_of_week'=>3,'en'=>'Wednesday',     'ar'=>'الأربعاء'],
        ['day_of_week'=>4,'en'=>'Thursday',      'ar'=>'الخميس '],
        ['day_of_week'=>5,'en'=>'Friday',        'ar'=>'الجمعة'],
        ['day_of_week'=>6,'en'=>'Saturday',      'ar'=>'السبت'],
    ];

    protected $fillable = ['day_of_week','day_text','center_id','is_active'];

    public $translatable =['day_text'];


    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class,'center_id');
    }
}
