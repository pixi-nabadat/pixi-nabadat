<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\QueryFilters\ProductsFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $products = $this->queryGet($where_condition);
        return $products->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $products = Product::query();
        return $products->filter(new ProductsFilter($where_condition));
    }

    public function store($data)
    {
        isset($data['featured'])  ?   $data['featured']=1 : $data['featured']= 0;
        return product::create($data);
    } //end of store

    public function find($id)
    {

        $product = Product::find($id);
        if ($product)
            return $product;
        return false;

    } //end of find

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            return $product->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $product = Product::find($id);
        isset($data['featured'])  ?   $data['featured']=1 : $data['featured']= 0;
        if ($product) {
            $product->update($data);
        }
        return false;
    } //end of update

    public function featured($id)
    {
        $product = Product::find($id);
        $product->featured = !$product->featured;
        $product->save();

    }//end of featured

}
