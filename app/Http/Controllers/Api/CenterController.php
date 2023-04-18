<?php

namespace App\Http\Controllers\Api;


use App\Enum\ActivationStatusEnum;
use App\Events\PushEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCenterRequestApi;
use App\Http\Requests\UpdateCenterRequestApi;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\CenterResource;
use App\Http\Resources\CentersResource;
use App\Models\FcmMessage;
use App\Services\CenterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            if (isset($request->location_id))
                $filters['location_id'] = $request->location_id;
            $filters = array_merge($filters, $request->except('location_id'));

            $withRelations = ['user', 'defaultLogo'];
            $centers = $this->centerService->listing(filters: $filters, withRelation: $withRelations);
            return CentersResource::collection($centers);
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), 'Unauthorized', $e->getCode());
        }
    }

    public function show(int $id)
    {
        try {

            $withRelations = [
                'rates' => fn($rates) => $rates->where('status', ActivationStatusEnum::ACTIVE)->orderByDesc('rate_number')->limit(10),
                'rates.user:id,name', 'rates.user.attachments', 'doctors.defaultLogo',
                'user.attachments', 'user.location:id,title',
                'attachments', 'appointments', 'devices.attachments', 'packages'
            ];
            $center = $this->centerService->find($id, $withRelations);
            return apiResponse(data: new CenterResource($center));

        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function store(StoreCenterRequestApi $request)//: \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
                 $center = $this->centerService->store($request->validated());
            DB::commit();
            event(new PushEvent($center, FcmMessage::DEAL_WITH_NEW_CENTER));
            return apiResponse(message: trans('lang.created_successfully'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function update(UpdateCenterRequestApi $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $user = $user->load('center');
            $this->centerService->update(centerId: $user->center_id, data: $request->validated());
            DB::commit();
            $user->refresh();
            return apiResponse(data: new AuthUserResource($user));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }


}
