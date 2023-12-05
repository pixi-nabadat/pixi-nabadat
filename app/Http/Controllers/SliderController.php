<?php

namespace App\Http\Controllers;

use App\DataTables\SlidersDataTable;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\SliderRequest as SliderUpdateRequest;
use App\Models\Slider;
use App\Services\CenterService;
use App\Services\ProductService;
use App\Services\SliderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(private SliderService $sliderService, private CenterService $centerService, private ProductService $productService)
    {

    }

    public function index(SlidersDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_slider'); 
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['sliderable'];
        return $dataTable->with(['filters' => $filters, 'withRelations' => $withRelations])->render('dashboard.sliders.index');

    }//end of index

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_slider');
        try {
            $withRelation = ['attachments'];
            $filters = ['is_active'=>1];
            $slider = $this->sliderService->find(id: $id,withRelation: $withRelation);
            if($slider->type == Slider::CENTER)
                $sliderables = $this->centerService->getAll(where_condition: $filters);
            else
                $sliderables = $this->productService->getAll(where_condition: $filters);

            return view('dashboard.sliders.edit', compact('slider', 'sliderables'));
        }catch (\Exception $exception)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    }//end of edit 

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_slider');
        $filters = ['is_active'=> 1];
        $centers = $this->centerService->getAll(where_condition:$filters);
        $products = $this->productService->getAll(where_condition:$filters);
        return view('dashboard.sliders.create', compact('centers', 'products'));
    }//end of create

    public function store(SliderRequest $request)
    {
        userCan(request: $request, permission: 'create_slider');
        try {
            $data = $request->validated();
            $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');

            $this->sliderService->store($data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'slider Saved Successfully'];
            return redirect()->route('sliders.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(SliderUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_slider');
        try {
            $data = $request->validated();
            $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');
            $this->sliderService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('sliders.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_slider');
        try {
            $this->sliderService->delete($id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_slider');
        try {
            $slider = $this->sliderService->find($id);
            return view('dashboard.sliders.show', compact('slider'));
        }catch (\Exception $exception)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }

    } //end of show   

    public function status(Request $request)
    {
        try {
            $this->sliderService->status($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
