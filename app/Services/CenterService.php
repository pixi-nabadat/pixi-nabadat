<?php

namespace App\Services;


use App\Models\Center;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\GetListCenterResource;
use App\Traits\HasAttachment;
class CenterService extends BaseService
{

    use HasAttachment;

    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $centers = Center::query()->with('Location');
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [])
    {
        $centers = $this->queryGet($where_condition);
        $centers = $centers->cursorPaginate(10);
        return GetListCenterResource::collection($centers);
    }

    public function store(array $centerData = [])
    {
        $center = Center::create($centerData);
        if (! $center)
            return false;
        if (isset($centerData['images'])&&is_array($centerData['images']))
            foreach ($centerData['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads/centers');
                $center->storeAttachment($fileData);
            }
        return false;
    }

    public function getCenterById($id)
    {
        return Center::find($id);
    }

    public function find($id,$with=[])
    {
        $center = Center::with($with)->find($id);
        if ($center)
            return $center;
        return false;
    }


    public  function update(int $centerId, array $centerData)
    {
        $center = $this->find($centerId);
        if ($center) {
            if (isset($centerData['images'])&&is_array($centerData['images']))
                foreach ($centerData['images'] as $image)
                {
                    $fileData = FileService::saveImage(file: $image,path: 'uploads/centers');
                    $center->storeAttachment($fileData);
                }
            $center->update($centerData);
        }
        return false;
    }

    public function changeStatus($id)
    {
        $center = Center::find($id);
        $center->is_active = !$center->is_active;
        $center->save();
    }

    public function delete($id): bool
    {
        $center = $this->find($id);
        if ($center) {
            $center->deleteAttachments();
            return $center->delete();
        }
        return false;
    }
}
