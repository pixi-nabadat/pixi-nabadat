<?php

namespace App\Http\Controllers;

use App\DataTables\SlidersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(private SliderService $sliderService)
    {
        
    }
    
    public function index(SlidersDataTable $dataTable, Request $request){

        $filters = $request->all();
        $withRelations = ['package'];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('dashboard.sliders.index');

    }//end of index

    public function edit($id){
        $slider = $this->sliderService->find($id);
        if (!$slider)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.slider_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.sliders.edit', compact('slider'));
    }//end of edit 

    public function create(){
        return view('dashboard.sliders.create');
    }//end of create

    public function store(SliderStoreRequest $request){
        try {
            $request->validated();
            $this->sliderService->store($request->all());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'slider Saved Successfully'];
            return redirect()->route('sliders.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(SliderUpdateRequest $request, $id)
    {
        try {
            $request->validated();
            $this->sliderService->update($id, $request->all());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('sliders.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update
    
    public function destroy($id)
    {
        try {
            $result = $this->sliderService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $slider = $this->sliderService->find($id);
        if (!$slider){
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.slider_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.sliders.show', compact('slider'));
    } //end of show   

    public function status(Request $request)
    {
        try {
            $result =  $this->sliderService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
