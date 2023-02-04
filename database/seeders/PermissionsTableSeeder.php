<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            //start country permissions
            ['name'=> 'create_country'],
            ['name'=> 'edit_country'],
            ['name'=> 'delete_country'],
            ['name'=> 'view_country'],
            //end country permissions

            //start city permissions
            ['name'=> 'create_city'],
            ['name'=> 'edit_city'],
            ['name'=> 'delete_city'],
            ['name'=> 'view_city'],
            //end city permissions

            //start governorate permissions
            ['name'=> 'create_governorate'],
            ['name'=> 'edit_governorate'],
            ['name'=> 'delete_governorate'],
            ['name'=> 'view_governorate'],
            //end governorate permissions

            //start employee permissions
            ['name'=> 'create_employee'],
            ['name'=> 'edit_employee'],
            ['name'=> 'delete_employee'],
            ['name'=> 'view_employee'],
            //end employee permissions

            //start client permissions
            ['name'=> 'create_client'],
            ['name'=> 'edit_client'],
            ['name'=> 'delete_client'],
            ['name'=> 'view_client'],
            //end client permissions

            //start center permissions
            ['name'=> 'create_center'],
            ['name'=> 'edit_center'],
            ['name'=> 'delete_center'],
            ['name'=> 'view_center'],
            //end center permissions

            //start packages permissions
            ['name'=> 'create_package'],
            ['name'=> 'edit_package'],
            ['name'=> 'delete_package'],
            ['name'=> 'view_package'],
            //end packages permissions

            //start devices permissions
            ['name'=> 'create_device'],
            ['name'=> 'edit_device'],
            ['name'=> 'delete_device'],
            ['name'=> 'view_device'],
            //end devices permissions

            //start reservations permissions
            ['name'=> 'create_reservation'],
            ['name'=> 'edit_reservation'],
            ['name'=> 'delete_reservation'],
            ['name'=> 'view_reservation'],
            //end reservations permissions

            //start doctors permissions
            ['name'=> 'create_doctor'],
            ['name'=> 'edit_doctor'],
            ['name'=> 'delete_doctor'],
            ['name'=> 'view_doctor'],
            //end doctors permissions

            //start categories permissions
            ['name'=> 'create_category'],
            ['name'=> 'edit_category'],
            ['name'=> 'delete_category'],
            ['name'=> 'view_category'],
            //end categories permissions

            //start sliders permissions
            ['name'=> 'create_slider'],
            ['name'=> 'edit_slider'],
            ['name'=> 'delete_slider'],
            ['name'=> 'view_slider'],
            //end sliders permissions

            //start coupons permissions
            ['name'=> 'create_coupon'],
            ['name'=> 'edit_coupon'],
            ['name'=> 'delete_coupon'],
            ['name'=> 'view_coupon'],
            //end coupons permissions

            //start products permissions
            ['name'=> 'create_product'],
            ['name'=> 'edit_product'],
            ['name'=> 'delete_product'],
            ['name'=> 'view_product'],
            //end products permissions

            //start cancel_reasons permissions
            ['name'=> 'create_cancel_reason'],
            ['name'=> 'edit_cancel_reason'],
            ['name'=> 'delete_cancel_reason'],
            ['name'=> 'view_cancel_reason'],
            //end cancel_reasons permissions

            //start center_devices permissions
            ['name'=> 'create_center_device'],
            ['name'=> 'edit_center_device'],
            ['name'=> 'delete_center_device'],
            ['name'=> 'view_center_device'],
            //end center_devices permissions

            //start orders permissions
            ['name'=> 'create_order'],
            ['name'=> 'edit_order'],
            ['name'=> 'delete_order'],
            ['name'=> 'view_order'],
            //end orders permissions

            //start settings permissions
            ['name'=> 'edit_settings'],
            //end settings permissions

            //start invoices permissions
            ['name'=> 'create_invoice'],
            ['name'=> 'edit_invoice'],
            ['name'=> 'delete_invoice'],
            ['name'=> 'view_invoice'],
            //end invoices permissions


        ];
        $user = User::find(1);
        foreach($permissions as $permission)
        {
            Permission::create($permission);
            $user->givePermissionTo($permission);
        }
    }
}
