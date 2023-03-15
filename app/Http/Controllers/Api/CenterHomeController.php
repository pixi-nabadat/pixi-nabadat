<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationsResource;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Cache;

class CenterHomeController extends Controller
{
    public function __construct(protected ReservationService $reservationService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $centerId = auth('sanctum')->user()->center_id;
        $data = Cache::remember('center-home-api', 60 * 60 * 24, function () use ($centerId) {
            $data ['upcoming_reservations'] = ReservationsResource::collection($this->reservationService->queryGet(where_condition: ['center_id' => $centerId, 'status' => Reservation::PENDING], withRelation: ['user.attachments', 'latestStatus'])->orderByDesc('id')->limit(8)->get());
            return $data;
        });
        return apiResponse(data: $data);
    }
}
