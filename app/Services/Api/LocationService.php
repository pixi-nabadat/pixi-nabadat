<?php

namespace App\Services\Api;
use App\Models\Location;
use App\Repositories\LocationRepository;
use App\Http\Resources\GetListCountriesResource;
use App\Http\Resources\GetListGovernoratesResource;
use App\Traits\ApiResponses;
use App\Exceptions\NotFoundHttpException;
use App\Services\BaseService;

class LocationService extends BaseService
{
    use ApiResponses;

    private $locationRepo;

    public function __construct(LocationRepository $locRepo)
    {
        $this->locationRepo = $locRepo;
    }

    public function listCountries()
    {
        try{
            $countries = $this->locationRepo->listCountries();
            $list['status'] = true;
            $list['list'] = GetListCountriesResource::collection($countries);
            return $this->successResponse($list);
        } catch(\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function listGovernorates($id)
    {
        $location = $this->locationRepo->getCountryById($id);
        if (is_null($location)) {
            throw new NotFoundHttpException('this location not found', 400);
        }
        $countryWithGovernorates = $this->locationRepo->listChildren($id);
        $governorates = $countryWithGovernorates->children;
        $list['status'] = true;
        $list['list'] = GetListGovernoratesResource::collection($governorates);
        return $this->successResponse($list);
    }


}
