<?php

namespace App\Services;

use App\Models\Location;
use App\QueryFilters\LocationsFilter;

class LocationService extends BaseService
{
    /**
     * @param array $filter
     * @return mixed
     */
    public function queryGet(array $filter = [])
    {
        $result = Location::query();
        return $result->filter(new LocationsFilter($filter));

    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getAll(array $filters = [])
    {
        return $this->queryGet($filters)->get();
    }

    /**
     * @param array $locationData
     * @return mixed
     */
    public function store(array $locationData = []): mixed
    {
        $locationData['is_active'] = isset($locationData['is_active'])  ?  1 :  0;
        return Location::create($locationData);
    }

    /**
     * @param int $id
     * @param array $locationData
     * @return false
     */
    public function update(int $id,array $locationData): bool
    {
        $location = Location::find($id);
        $data['is_active'] = isset($locationData['is_active'])  ?  1 :  0;

        if ($location)
            return $location->update($locationData);
        return false;
    }

    public function delete($id): bool
    {
        $location = Location::find($id);
        if ($location)
            return $location->delete();
        return false;
    }

    public function getLocationById($id)
    {
        return Location::find($id);
    }

    public function getLocationAncestors($id)
    {
        return Location::defaultOrder()->ancestorsAndSelf($id);
    }

    public function getLocationDescendants($location_id)
    {
        return Location::defaultOrder()->descendantsOf($location_id) ;
    }
}
