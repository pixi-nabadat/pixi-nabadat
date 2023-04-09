<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\Category;
use App\QueryFilters\CategoriesFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\AttachmentTrait;

class CategoryService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelation=[])
    {
        return $this->queryGet($where_condition,$withRelation)->get();

    }

    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $categories = category::query()->with($with);
        return $categories->filter(new CategoriesFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        $category = Category::create($data);

        if (!$category)
            return false ;

        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/categories', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $category->storeAttachment($fileData);
        }

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

            $category->deleteAttachments();
            return $category->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        $category = category::find($id);
        if ($category) {

            if (isset($data['logo']))
            {
                $category->deleteAttachmentsLogo();
                $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/categories', field_name: 'logo');
                $fileData['type'] = ImageTypeEnum::LOGO;
                $category->storeAttachment($fileData);
            }

            $category->update($data);
        }
        return false;
    } //end of update

    public function changeStatus($id)
    {
        $category = Category::find($id);
        $category->is_active = !$category->is_active;
        return $category->save();
    }//end of changeStatus
}
