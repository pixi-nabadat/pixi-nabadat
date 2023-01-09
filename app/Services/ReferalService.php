<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\QueryFilters\ReservationsFilter;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ReferalService extends BaseService
{

    /**
     * @param int $userId
     */
    public function setReferalPoints(array $data): bool
    {
        $user = User::where('referal_code', $data['referal_code'])->first();
        return User::setPoints(user: $user, amount: 30, amountType: 'points');//30 is the points add I should get it from settings
    }

}
