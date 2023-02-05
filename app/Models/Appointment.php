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
        ['en'=>'Sunday',        'ar'=>'الاحد '],//0
        ['en'=>'Monday',        'ar'=>'الاثنين'],//1
        ['en'=>'Tuesday',       'ar'=>'الثلاثاء'],//2
        ['en'=>'Wednesday',     'ar'=>'الأربعاء'],//3
        ['en'=>'Thursday',      'ar'=>'الخميس '],//4
        ['en'=>'Friday',        'ar'=>'الجمعة'],//5
        ['en'=>'Saturday',      'ar'=>'السبت'], //6
    ];

    protected $fillable = ['day_of_week','day_text','center_id','is_active','to','from'];

    public $translatable =['day_text'];

    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class,'center_id');
    }
}
