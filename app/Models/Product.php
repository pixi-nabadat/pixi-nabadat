<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','added_by','category_id','description','unit_price','purchase_price','discount',
    'discount_type','discount_start_date','discount_end_date','tax','num_points'];

}
