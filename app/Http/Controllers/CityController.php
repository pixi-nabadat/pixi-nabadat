<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\DataTables\CitiesDataTable;
use App\Services\LocationService;
use App\Http\Requests\StoreLocationRequest;

class CityController extends Controller
{

    private function LocationServiceObj(): LocationService
    {
        return new LocationService();
    }


    public function index(CitiesDataTable $dataTables)
    {
        return $dataTables->render('dashboard.locations.city.index');
    }

    public function create()
    {
        $governates = Location::withDepth()->having('depth', '=', 1)->get();
        return view('dashboard.locations.city.form')->with('governates' , $governates);
    }

    public function store(StoreLocationRequest $request)
    {
        $cityData = $request->all();
        return $this->LocationServiceObj()->storeLocation($cityData);
    }

    public function edit($id)
    {
        $city = $this->LocationServiceObj()->getLocation($id);
        $city->title_translations = $city->getTranslations('title');
        $governates = $this->LocationServiceObj()->getAllGovernorates();
        return view('dashboard.locations.city.edit')->with(['city' => $city, 'governates' =>$governates]);
    }

    public function update($id, StoreLocationRequest $request)
    {
        return $this->LocationServiceObj->updateLocation($id, $request);
    }

    public function delete($id)
    {
        return $this->LocationServiceObj()->deleteLocation($id);
    }

    public function show($id)
    {
        $city = $this->LocationServiceObj()->getLocation($id);
        return view('dashboard.locations.city.show')->with('city', $city);
    }
}
