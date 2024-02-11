<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\PackageCategory;
use App\QueryFilters\PackageCategoriesFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\AttachmentTrait;

class PackageCategoryService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelation=[])
    {
        return $this->queryGet($where_condition,$withRelation)->get();

    }

    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $packageCategories = PackageCategory::query()->with($with);
        return $packageCategories->filter(new PackageCategoriesFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        $PackageCategory = PackageCategory::create($data);

        if (!$PackageCategory)
            return false ;

        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/packageCategories', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $PackageCategory->storeAttachment($fileData);
        }

    } //end of store

    public function find($id)
    {

        $PackageCategory = PackageCategory::find($id);
        if ($PackageCategory)
            return $PackageCategory;
        return false;

    } //end of find

    public function delete($id)
    {
        $PackageCategory = PackageCategory::find($id);
        if ($PackageCategory) {

            $PackageCategory->deleteAttachments();
            return $PackageCategory->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        $PackageCategory = PackageCategory::find($id);
        if ($PackageCategory) {

            if (isset($data['logo']))
            {
                $PackageCategory->deleteAttachmentsLogo();
                $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/packageCategories', field_name: 'logo');
                $fileData['type'] = ImageTypeEnum::LOGO;
                $PackageCategory->storeAttachment($fileData);
            }

            $PackageCategory->update($data);
        }
        return false;
    } //end of update

    public function changeStatus($id)
    {
        $PackageCategory = PackageCategory::find($id);
        $PackageCategory->is_active = !$PackageCategory->is_active;
        return $PackageCategory->save();
    }//end of changeStatus
}
