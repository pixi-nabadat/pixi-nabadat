<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserPackage;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class UserService extends BaseService
{

    public function getAll(array $where_condition = [],$withRelations=[]): \Illuminate\Database\Eloquent\Collection|array
    {
        $users = $this->queryGet($where_condition,$withRelations);
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
        $data['allow_notification'] = isset($data['allow_notification']) ? 1 : 0;
        $user = User::create($data);
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\users', field_name: 'logo');
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

    /**
     * @throws NotFoundException
     */
    public function find($id, $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|bool|array
    {
        $user = User::with($withRelations)->find($id);
        if (!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        return $user;
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
        if (isset($data['password']) && $data['password'] !=null)
            $data['password'] = bcrypt($data['password']);
        else
            Arr::forget($data,'password');
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active']) ? $data['is_active'] = 1 : $data['is_active'] = 0;
        $data['allow_notification'] = isset($data['allow_notification']) ? 1 : 0;

        $user = $this->find($id);
        if (!$user)
            return false;
        if (isset($data['logo']))
        {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\users', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        $user->update($data);
    }//end of update

    public function updateOrCreateNabadatWallet(User $user,UserPackage $userPackage): bool
    {
        $old_pulses = optional($user->nabadatWallet)->total_pulses ?? 0;
        $total_pulses = $old_pulses + $userPackage->num_nabadat;
        if ($userPackage && $userPackage->payment_status == PaymentStatusEnum::PAID){
            $user->nabadatWallet()->updateOrCreate(['user_id'=>$user->id],['total_pulses' => $total_pulses]);
        }
        return true;
    }


    public function status($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        return $user->save();
    }//end of status

    public function getAuthUser()
    {
        $user =auth()->user();
        if (!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        else
            return $user;

    }
}
