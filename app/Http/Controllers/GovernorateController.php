<?php

namespace App\Http\Controllers;

use App\DataTables\GovernoratesDataTable;
use App\Http\Requests\StoreLocationRequest;
use App\Services\LocationService;

class GovernorateController extends Controller
{

    private function LocationServiceObj(): LocationService
    {
        return new LocationService();
    }

    public function index(GovernoratesDataTable $dataTables)
    {
        return $dataTables->render('dashboard.locations.governorate.index');
    }

    public function create()
    {
        $countries = $this->LocationServiceObj()->getAllCountries();
        return view('dashboard.locations.governorate.form')->with('countries',$countries);
    }

    public function store(StoreLocationRequest $request)
    {
        $governoareteData = $request->all();
        return $this->LocationServiceObj()->storeLocation($governoareteData);
    }

    public function edit($id)
    {
        $governorate = $this->LocationServiceObj()->getLocation($id);
        $countries = $this->LocationServiceObj()->getAllCountries();
        $governorate->title_translations = $governorate->getTranslations('title');
        return view('dashboard.locations.governorate.edit')->with(['governorate'  => $governorate, "countries" => $countries]);
    }

    public function update($id, StoreLocationRequest $request)
    {
        $governoareteData = $request->all();
        return $this->LocationServiceObj()->updateLocation($id, $governoareteData);
    }

    public function delete($id)
    {
        return $this->LocationServiceObj()->deleteLocation($id);
    }

    public function show($id)
    {
        $country = $this->LocationServiceObj()->getLocation($id);
        return view('dashboard.locations.country.show')->with('country', $country);
    }
}
