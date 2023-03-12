<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Reservation;
use App\Services\ReservationService;
use Exception;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct(private ReservationService $reservationService)
    {
    }

    public function cancelationReport()
    {
        try{
            $filters['center_id'] = auth('sanctum')->user()->center_id;
            $filters['status'] = Reservation::CANCELED;
            $withRelations = ['latestStatus'];
            $cancelationReport = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            if(!$cancelationReport)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
           return ReportResource::collection($cancelationReport);
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }

    }

    public function approvedReport()
    {
        try{
            $filters['center_id'] = auth('sanctum')->user()->center_id;
            $filters['status'] = Reservation::CONFIRMED;
            $withRelations = ['latestStatus'];
            $approvedReport = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            if(!$approvedReport)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
           return ReportResource::collection($approvedReport);
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }

    }

    public function areasReportBySales(int $locationId)
    {
        try{
            $filters['center_id'] = auth('sanctum')->user()->center_id;
            $filters['location_id'] = $locationId;
            $withRelations = ['latestStatus', 'user'];
            $areasReport = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            if(!$areasReport)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
           return ReportResource::collection($areasReport);
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }
    }
}
