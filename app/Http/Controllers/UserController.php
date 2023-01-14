<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {

    }

    public function index(UsersDataTable $dataTable, Request $request)
    {
        $filters = $request->all();
        $withRelations = [] ;
        return $dataTable->with(['filters'=>$filters,'withRelations'=>$withRelations])->render('dashboard.users.index');
    }//end of index

    public function destroy($id)
    {
        try {
            $result = $this->userService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function status(Request $request)
    {
        try {
            $result = $this->userService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status

}
