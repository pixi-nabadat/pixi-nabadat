<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use App\Models\Location;

class CountryService extends BaseService
{

    private $locRepo;

    public function __construct(LocationRepository $loc_repo)
    {
        $this->locRepo = $loc_repo;
    }

    public function updateLocation($id, $request)
    {
        try{
            if(!empty($request->slug)) {
                $countryData['slug'] = $request->slug;
            }
            if(!empty($request->title_en)) {
               $translatedTitle['en'] = $request->title_en;
            }
            if(!empty($request->title_ar)) {
               $translatedTitle['ar'] = $request->title_ar;
            }
            $countryData['title'] = $translatedTitle;
            if(!empty($request->iso_code_2)) {
                $countryData['iso_code_2'] = $request->iso_code_2;
            }
            if(!empty($countryData)) {
                $this->update($id, $countryData);
            }
            return true;
        } catch(\Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function update($id, $data)
    {
        return $this->locRepo->updateLocation($id, $data);
    }

    public function PrepareLocationData($locationData)
    {
        try {
            $data = [];
            if (!empty($locationData)) {
                $data['slug'] = $locationData['slug'];
                $data['title'] = [
                    'en' => $locationData['title_en'],
                    'ar' => $locationData['title_ar'],
                ];
                $data['iso_code_2'] = $locationData['iso_code_2'];
                $data['currency_id'] = $locationData['currency_id'];
            }
            $this->saveLocation($data);
            return true;
        } catch(\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function saveLocation($data)
    {
        return  Location::create($data);
    }
}
