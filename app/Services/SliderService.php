<?php

namespace App\Services;

use App\Models\Slider;
use App\QueryFilters\SlidersFilter;
use Illuminate\Database\Eloquent\Builder;

class SliderService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelations = [])
    {
        $sliders = $this->queryGet($where_condition, $withRelations);
        return $sliders->get();
    }

    public function listing(array $where_condition = [], array $withRelations = [])
    {
        $perPage = config('app.perPage');
        return $this->queryGet($where_condition, $withRelations)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], array $withRelation = []): Builder
    {
        $sliders = Slider::query()->orderBy('order')->with($withRelation);
        return $sliders->filter(new SlidersFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        return Slider::create($data);
    } //end of store

    public function delete($id)
    {
        $slider = $this->find($id);
        if (!$slider)
            return false;
        return $slider->delete();

    } //end of find

    public function find($id, $withRelation = [])
    {
        $slider = Slider::with($withRelation)->find($id);
        if ($slider)
            return $slider;
        return false;
    } //end of delete

    public function update($id, $data): bool|int
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $slider = $this->find($id);
        if (!$slider)
            return false;
        return $slider->update($data);
    } //end of update

    public function status($id): bool
    {
        $slider = $this->find($id);
        $slider->is_active = !$slider->is_active;
        return $slider->save();

    }//end of status
}
