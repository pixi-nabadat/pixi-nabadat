<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLocationRequest;
use App\DataTables\CountriesDataTable;
use App\Models\Currency;
use App\Services\LocationService;

class CountryController extends Controller
{

    public function __construct(private LocationService $locationService)
    {

    }

    public function index(CountriesDataTable $dataTables,Request $request)
    {
        $request = $request->merge(['depth'=>0,'is_active'=>$request->is_active??1]);
        return $dataTables->with(['filters'=>$request->all()])->render('dashboard.locations.country.index');
    }

    public function create()
    {
        $currencies = Currency::all();
        return view('dashboard.locations.country.create', compact('currencies'));
    }

    public function store(StoreLocationRequest $request)
    {
        try {
            $this->locationService->store($request->all());
            $toast=[
                'type'=>'success',
                'title'=>trans('lang.title'),
                'message'=> 'country saved Successfully'
            ];
            return redirect()->route('country.index')->with('toast', $toast);
        }catch (\Exception $exception)
        {
            $toast=[
                'type'=>'error',
                'title'=>trans('lang.error'),
                'message'=>$exception->getMessage()
            ];
            return back()->with('toast',$toast);
        }
    }

    public function edit($id)
    {
        $country = $this->locationService->getLocationById($id);
        if (!$country)
        {
            $toast = [
              'type'=>'error',
              'title'=>trans('error'),
              'message'=>trans('lang.not_found')
            ];
            return back()->with('toast',$toast);
        }
        $currencies = Currency::all();
        return view('dashboard.locations.country.edit',['country' => $country, 'currencies' => $currencies]);
    }

    public function update($id, StoreLocationRequest $request)
    {
        try {
            $this->locationService->update($id, $request->all());
            $toast=[
                'type' => 'success',
                'title'=>trans('lang.success'),
                'message'=>trans('lang.success')
            ];
            return  redirect(route('country.index'))->with('toast',$toast);
        }catch (\Exception $exception)
        {
            $toast = [
                'type'=>'error',
                'title'=>trans('lang.error'),
                'message'=>$exception->getMessage()
            ];
            return back()->with('toast',$toast);
        }
    }

    public function destroy($id)
    {
        try {
            $result =  $this->locationService->delete($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success'));

        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }

    public function show($id)
    {

    }
}
