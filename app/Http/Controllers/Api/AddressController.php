<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Services\AddressService;
use App\Http\Resources\AddressesResource;
use Illuminate\Support\Facades\Auth;
class AddressController extends Controller
{
    public function __construct(private AddressService $addressService)
    {
    }

    public function index()
    {
        try {
            $filters = ['user_id'=>auth()->id()];
            $relations = ['city','governorate'];
            $addresses = $this->addressService->getAll($filters, $relations);
            return AddressesResource::collection($addresses);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of index


    public function store(AddressRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $addresses = $this->addressService->store($request->validated());
            return apiResponse(data: $addresses, message: trans('lang.address_updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of store

    public function update(AddressRequest $request, $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        try {
            $addresses = $this->addressService->update($id, $request->validated());
            return apiResponse(data: $addresses, message: trans('lang.address_updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of update

    public function destroy($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $result = $this->addressService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function find($id): \Illuminate\Http\Response|AddressesResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $address = $this->addressService->find($id);
            return new AddressesResource($address);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of find

    public function setDefault($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->addressService->setDefault($id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

}
