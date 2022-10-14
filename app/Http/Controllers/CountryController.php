<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\DataTables\CountriesDataTable;
use App\Services\LocationService;

class CountryController extends Controller
{
    private function LocationServiceObj(): LocationService
    {
        return new LocationService();
    }

    public function index(CountriesDataTable $dataTables)
    {
        return $dataTables->render('dashboard.locations.country.index');
    }

    public function create()
    {
        return view('dashboard.locations.country.form');
    }

    public function store(StoreLocationRequest $request)
    {
        $countryData = $request->all();
        return $this->LocationServiceObj()->storeLocation($countryData);
    }

    public function edit($id)
    {
        $country = $this->LocationServiceObj()->getLocation($id);
        $country->title_translations = $country->getTranslations('title');
        return view('dashboard.locations.country.edit')->with('country' , $country);
    }

    public function update($id, StoreLocationRequest $request)
    {
        return $this->LocationServiceObj()->updateLocation($id, $request);
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
