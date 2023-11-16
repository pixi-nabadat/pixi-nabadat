<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Reservation;
use App\Models\ReservationHistory;
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
        $lastCustomers = User::where('type',User::CENTERADMIN)->latest()->take(5)->get();
        $customerReviews = Rate::whereHasMorph('ratable', [Center::class, Product::class])->with('user.attachments')->latest()->take(5)->get();
        $topSellingProducts = Product::withCount('orderItems')
        ->whereHas('orderItems')
        ->orderBy('order_items_count', 'desc')
        ->latest()->take(3)->get();

        $topSellingDoctors = Center::withCount('userPackages')
        ->whereHas('userPackages')
        ->orderBy('user_packages_count', 'desc')
        ->latest()->take(5)->get();

        $cancelCenterCount = ReservationHistory::query()->where('status', Reservation::CANCELED)->whereNotNull(['added_by'])->whereHas('added_by', function ($query) {
            $query->whereNotNull('center_id');
        })->count();

        $cancelClientCount = ReservationHistory::query()->where('status', Reservation::CANCELED)->whereNotNull(['added_by'])->whereHas('added_by', function ($query) {
            $query->whereNull('center_id');
        })->count();
        $centerDues = Invoice::sum('total_center_dues');
        $nabadatDues = Invoice::sum('total_nabadat_dues');

        $waitReservations = Reservation::query()->whereHas('latestStatus', function ($query) {
            $query->whereNotIn('status', [Reservation::COMPLETED, Reservation::Expired, Reservation::CANCELED]);
        })->count();
        $doneReservations = Reservation::query()->whereHas('latestStatus', function ($query) {
            $query->where('status', Reservation::COMPLETED);
        })->count();
        $cancelReservations = Reservation::query()->whereHas('latestStatus', function ($query) {
            $query->where('status', Reservation::CANCELED);
        })->count();
       return view('dashboard.index',[
           'users_count'=>$users_count,
           'centers_count'=>$centers_count,
           'products_count'=>$products_count,
           'test_count'=>$users_count,
           'last_customers'=>$lastCustomers,
           'customer_reviews'=>$customerReviews,
           'top_selling_products'=>$topSellingProducts,
           'top_selling_doctors'=>$topSellingDoctors,
           'cancel_center_count'=>$cancelCenterCount,
           'cancel_client_count'=>$cancelClientCount,
           'center_dues'=>$centerDues,
           'nabadat_dues'=>$nabadatDues,
           'wait_reservations'=>$waitReservations,
           'done_reservations'=>$doneReservations,
           'cancel_reservations'=>$cancelReservations,
       ]);
    return "done";
    }
}
