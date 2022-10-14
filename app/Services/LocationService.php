<?php

namespace App\Services;

use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Support\Facades\Auth;
class LocationService extends BaseService
{
    public function storeLocation($locationData)
    {
        try {
            $data = [];
            if (!empty($locationData)) {
                $data['slug'] = $locationData['slug'];
                $data['title'] = [
                    'en' => $locationData['title_en'],
                    'ar' => $locationData['title_ar'],
                ];
                $data['created_by'] = Auth::user()->id ?? 1;
                $data['currency_id'] = $locationData['currency_id'] ?? NULL;
                $data['parent_id'] = $locationData['parent_id'] ?? NULL;
                $data['is_active'] = $locationData['is_active'] ?? 0;
            }
            Location::create($data);
            $toast = [
                'type'=>'success',
                'title'=>'Success',
                'message'=> 'Country Saved Successfully'
            ];
            return redirect()->back()->with('toast',$toast);
        } catch(\Exception $ex) {
            $toast =[
                'type'=>'error',
                'title'=>'error',
                'message'=> $ex->getMessage(),
            ];
            return redirect()->back()->with('toast',$toast);
        }
    }

    public function updateLocation($id, $locationData)
    {
        try{
            if(!empty($locationData['slug'])) {
                $countryData['slug'] = $locationData['slug'];
            }
            if(!empty($locationDatatitle_en)) {
               $translatedTitle['en'] = $locationData['title_en'];
            }
            if(!empty($locationData['title_ar'])) {
               $translatedTitle['ar'] = $locationData['title_ar'];
            }
            $countryData['title'] = $translatedTitle;
            if(!empty($locationData['currency_id'])) {
                $countryData['currency_id'] = $locationData['currency_id'];
            }
            if(!empty($locationData['parent_id'])) {
                $countryData['parent_id'] = $locationData['parent_id'];
            }
            if(!isset($locationData['is_active'])) {
                $countryData['is_active'] = $locationData['is_active'];
            }
            if(!empty($countryData)) {
                Location::where('id', $id)->update($countryData);
                $toast = [
                    'type'=>'success',
                    'title'=>'Success',
                    'message'=> 'Country Updated Successfully'
                ];
                return redirect()->back()->with('toast',$toast);
            }
            return true;
        } catch(\Exception $ex) {
            $toast =[
                'type'=>'error',
                'title'=>'error',
                'message'=> $ex->getMessage(),
            ];
            return redirect()->back()->with('toast',$toast);
        }
    }

    public function deleteLocation($id)
    {
        try {
            $location = Location::where('id', $id)->first();
            $location->delete();
            $toast = [
                'type'=>'errror',
                'title'=>'Success',
                'message'=> 'Country Deleted Successfully'
            ];
            return redirect()->back()->with('toast',$toast);
        } catch(\Exception $ex) {
            $toast =[
                'type'=>'error',
                'title'=>'error',
                'message'=> $ex->getMessage(),
            ];
            return redirect()->back()->with('toast',$toast);
        }
    }

    public function getAllCountries()
    {
        return Location::whereIsRoot()->where('is_active', 1)->get();
    }

    public function getAllGovernorates()
    {
        return Location::withDepth()->having('depth', '=', 1)->where('is_active', 1)->get();
    }

    public function getLocation($id)
    {
        return Location::where('id', $id)->first();
    }
}
