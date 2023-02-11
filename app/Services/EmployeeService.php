<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Models\Invoice;
use App\Models\User;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class EmployeeService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $users = $this->queryGet($where_condition);
        return $users->get();
    }

    public function queryGet(array $where_condition = [],$withRelation=[]): Builder
    {
        $users = User::query()->with($withRelation);
        return $users->filter(new UsersFilter($where_condition));
    }

    public function store($data)
    {

        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = isset($data['date_of_birth']) ? Carbon::parse($data['date_of_birth']) : null;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['type'] = User::EMPLOYEE;
        $user = User::create($data);
        $user->givePermissionTo($data['permissions']);
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\employees', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        return $user;

    } //end of create

    public function changeStatus($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        $user->save();
    }

    public function find($id, $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|bool|array
    {
        $user = User::with($withRelations)->find($id);
        if ($user)
            return $user;
        return false;
    }//end of changeStatus

    public function delete($id)
    {
        $user = $this->find($id);
        if ($user)
        {
            $user->deleteAttachments();
            return $user->delete();
        }
        return false;
    }//end of delete

    public function update($id, $data)
    {
        if (isset( $data['password']))
            $data['password'] = bcrypt($data['password']);
        $data['is_active'] = isset($data['is_active']) ? 1 :  0;

        $user = $this->find($id);
        if (!$user)
            return false;
        if (isset($data['logo']))
        {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\employees', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        $user->update($data);
        $user->syncPermissions($data['permissions']);
    }//end of update

    public function status($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        return $user->save();
    }//end of status
}
