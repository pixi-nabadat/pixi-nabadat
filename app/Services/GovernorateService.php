<?php

namespace App\Services;
use App\Repositories\LocationRepository;
use App\Models\Location;

class GovernorateService extends BaseService
{

    private $locRepo;

    private $parentId;

    public function __construct(LocationRepository $loc_repo)
    {
        $this->locRepo = $loc_repo;
        // $this->parentId = $parent_id;
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
            if(!empty($request->parent_id)) {
                $parent  =  Location::where('id', $request->parent_id)->first();
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
                if(!empty($locationData['parent_id'])) {
                    $parent  =  Location::where('id', $locationData['parent_id'])->first();
                }
            }
            $this->saveLocation($data, $parent);
            return true;
        } catch(\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function saveLocation($data, $parent)
    {
        return  Location::create($data, $parent);
    }
}
