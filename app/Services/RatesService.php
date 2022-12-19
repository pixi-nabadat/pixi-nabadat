<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use App\Models\Device;
use App\QueryFilters\DevicesFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\AttachmentTrait;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Rate;
class RatesService extends BaseService
{

   
    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data)//: bool
    {
        if(Str::title(Str::remove(" ", $data['item_type']))== "Product")
        {
            $item = Product::find($data['item_id']);
            
        }else if(Str::title(Str::remove(" ", $data['item_type']))== "Device"){
            $item = Device::find($data['item_id']);
            
        }
        $item->rates()->create([
            'user_id'=>$data['user_id'],
            'rate_number'=>$data['rate_number'],
            'comment'=>$data['comment']
        ]);
        return $this->refreshItemRate($item);
        
    }

    private function refreshItemRate(Product|Device $item): bool
    {
        $totalItemRate = $item->rates->sum('rate_number');
        $ratesCount = $item->rates->count();
        $finalRate = round(($totalItemRate / $ratesCount), 1, PHP_ROUND_HALF_EVEN);
        $item->update([
            'rate' => $finalRate
        ]);

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $rate = Rate::find($id);
        $rate->delete();
        return true;
    }
}
