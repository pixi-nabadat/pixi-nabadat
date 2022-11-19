<?php

namespace App\Services;


use App\Models\Center;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\GetListCenterResource;
use App\Models\User;
use App\Traits\HasAttachment;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
class CenterService extends BaseService
{

    use HasAttachment;

    public function queryGet(array $where_condition = [],$withRelation=[]): Builder
    {
        $centers = Center::query()->with($withRelation);
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function listing(array $filters = [] , array $withRelation =[] ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters,withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function store(array $data = []): bool
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        $data['is_support_auto_service'] = isset($data['is_active'])  ?  1 :  0;
        $center = Center::create($data);
        if (!$center)
            return false;
        if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads/centers');
                $center->storeAttachment($fileData);
            }

        $userData = $this->prepareUserData($data);

        return (new UserService)->store($userData);
    }

    private function prepareUserData($data): array
    {
        $userData = [
            'name'                       => $data['name'],
            'email'                      => $data['email'],
            'phone'                      => Arr::first($data['phone']),
            'user_name'                  => $data['user_name'],
            'password'                   => bcrypt($data['password']),
            'type'                       => User::CENTERTYPE,
            'is_active'                  => $data['is_active'] ?? 0,
            'location_id'                => $data['location_id'],
            'description'                => $data['description']??null,
        ];
        return $userData;
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
