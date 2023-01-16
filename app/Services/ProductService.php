<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Enum\ImageTypeEnum;
use App\Models\Product;
use App\QueryFilters\ProductsFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\AttachmentTrait;

class ProductService extends BaseService
{
    public function getAll(array $where_condition = [],$withRelation=[])
    {
        $products = $this->queryGet($where_condition,$withRelation);
        return $products->get();
    }

    public function queryGet(array $where_condition = [],array $withRelation = []): Builder
    {
        $products = Product::query()->with($withRelation);
        return $products->filter(new ProductsFilter($where_condition));
    }

    //method for api with pagination
    public function listing(array $where_condition = [],$withRelation=[],$perPage=10)
    {
        return $this->queryGet($where_condition,$withRelation)->cursorPaginate($perPage);
    }

    public function store($data)
    {
        $data['featured'] = isset($data['featured'])  ? 1 :  0;
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        $product = product::create($data);
        if (!$product)
            return false ;
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\products', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $product->storeAttachment($fileData);
        }
        if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads\products', field_name: 'galary');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $product->storeAttachment($fileData);
            }

    } //end of store

    public function find($id,$withRelation=[]): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $product = Product::with($withRelation)->find($id);
        if ($product)
            return $product;
        return false;

    } //end of find

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->deleteAttachments();
            return $product->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $product = $this->find($id);
        $data['featured'] = isset($data['featured'])  ? 1 :  0;
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        if ($product) {
            if (isset($data['logo']))
            {
                $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\products', field_name: 'logo');
                $fileData['type'] = ImageTypeEnum::LOGO;
                $product->storeAttachment($fileData);
            }
            if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads\products', field_name: 'galary');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $product->storeAttachment($fileData);
            }
            $product->update($data);
        }
        return false;
    } //end of update

    public function featured($id)
    {
        $product = $this->find($id);
        $product->featured = !$product->featured;
        return $product->save();

    }//end of featured

    public function status($id)
    {
        $product = $this->find($id);
        $product->is_active = !$product->is_active;
        return $product->save();

    }//end of status

}
