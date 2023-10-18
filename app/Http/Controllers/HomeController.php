<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class HomeController extends Controller
{

    public function __invoke()
    {
        $users_count = User::where('type',User::CUSTOMERTYPE)->count();
        $centers_count = User::where('type',User::CENTERADMIN)->count();
        $products_count = Product::query()->count();
        $lastCustomers = User::where('type',User::CENTERADMIN)->latest()->take(3)->get();
        $customerReviews = Rate::latest()->take(3)->get();

        $topSellingProducts = Product::withCount('orderItems')
        ->whereHas('orderItems')
        ->orderBy('order_items_count', 'desc')
        ->latest()->take(3)->get();

        $topSellingDoctors = Center::withCount('userPackages')
        ->whereHas('userPackages')
        ->orderBy('user_packages_count', 'desc')
        ->latest()->take(3)->get();

       return view('dashboard.index',[
           'users_count'=>$users_count,
           'centers_count'=>$centers_count,
           'products_count'=>$products_count,
           'test_count'=>$users_count,
           'last_customers'=>$lastCustomers,
           'customer_reviews'=>$customerReviews,
           'top_selling_products'=>$topSellingProducts,
           'top_selling_doctors'=>$topSellingDoctors,
       ]);
    return "done";
    }
}
