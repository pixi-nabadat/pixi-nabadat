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

    public function GetLocationAncestors($id)
    {
        // $location = $this->getLocationById($id);
        return Location::defaultOrder()->ancestorsAndSelf($id);
    }
}
