<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {
        $users_count = User::where('type',User::CUSTOMERTYPE)->count();
        $centers_count = User::where('type',User::CENTERADMIN)->count();
        $products_count = Product::query()->count();

       return view('dashboard.index',[
           'users_count'=>$users_count,
           'centers_count'=>$centers_count,
           'products_count'=>$products_count,
           'test_count'=>$users_count,
       ]);
    }
}
