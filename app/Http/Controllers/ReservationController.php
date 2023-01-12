<?php

namespace App\Http\Controllers;

use App\DataTables\ReservationDataTable;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request,ReservationDataTable $dataTable)
    {
        $withRelations = ['user','center'];
        $filters = $request->all();
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.reservations.index');
    }
}
