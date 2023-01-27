<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Resources\CentersResource;
use Illuminate\Http\Request;
use App\Services\CenterService;
use App\Services\LocationService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class CenterController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CenterService $centerService)
    {

    }

    public function index(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
//            handle filters from request
            $filters = ['is_active' => 1];
            if ($request->location_id != 'all')
                $filters['location_id'] = $request->location_id;
            $filters = array_merge($filters,$request->except('location_id'));

            $withRelations = ['doctors','user.location','attachments','appointments'];
            $centers = $this->centerService->listing(filters: $filters,withRelation: $withRelations);
            return CentersResource::collection($centers);
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), 'Unauthorized',$e->getCode());
        }
    }

    public function show(int $id)
    {
        try{
            $withRelations = ['doctors','user.location','attachments','appointments'];
            $center = $this->centerService->find($id, $withRelations);
            return apiResponse(data: new CentersResource($center));

        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function store(StoreCenterRequest $request)
    {

    }
}
