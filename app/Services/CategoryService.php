<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\QueryFilters\CategoriesFilter;
use Illuminate\Database\Eloquent\Builder;

class CategoryService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $categories = $this->queryGet($where_condition);
        return $categories->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $categories = category::query();
        return $categories->filter(new CategoriesFilter($where_condition));
    }

    public function store($data)
    {
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        return category::create($data);
    } //end of store

    public function find($id)
    {

        $category = category::find($id);
        if ($category)
            return $category;
        return false;

    } //end of find

    public function delete($id)
    {
        $category = category::find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        $category = category::find($id);
        if ($category) {
            $category->update($data);
        }
        return false;
    } //end of update

    public function changeStatus($id)
    {
        $category = Category::find($id);
        $category->is_active = !$category->is_active;
        $category->save();
    }//end of changeStatus
}
