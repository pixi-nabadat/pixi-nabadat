<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\DataTables\UsersDataTable;
use App\Http\Requests\DoctorRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function __construct(private UserService $UserService)
    {
    }

    public function index(DoctorsDataTable $dataTable, Request $request)
    {

        $request = $request->merge(['type' => User::DOCTORTYPE]); //filter Doctor users
        return $dataTable->with(['filters' => $request->all()])->render('dashboard.Doctors.index');
    } //end of index

    public function create()
    {
        return view('dashboard.Doctors.create');
    } //end of create

    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.Doctors.show', compact('user'));
    } //end of show

    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.Doctors.edit', compact('user'));
    } //end of edit

    public function store(DoctorRequest $request)
    {
        try {
            $request->validated();
            $request['type'] = User::DOCTORTYPE;

            $this->UserService->create($request->all());

            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Doctor Saved Successfully'];
            return redirect()->route('doctors.index')->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(Request $request, $id)
    {

        try {

            $request['type'] = User::DOCTORTYPE;
            $this->UserService->update($id,$request->all());

            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Doctor Updated Successfully'];
            return redirect()->route('doctors.index')->with('toast', $toast);

        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }

    } //end of update

    public function destroy($id)//done
    {
        try {
            $result = $this->UserService->delete($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success'));

        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    } //end of destroy

    public function changeStatus($id)//done
    {
        $this->UserService->changeStatus($id);
        $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Doctor status change Successfully'];
        return redirect()->route('doctors.index')->with('toast', $toast);
    } //end of changeStatus
}
