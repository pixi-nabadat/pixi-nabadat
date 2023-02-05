<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
           'locations'=>[
               'create_country',
               'edit_country',
               'delete_country',
               'view_country',
           ],
            //end country permissions

            //start city permissions
            'locations'=>[
                'create_city',
                'edit_city',
                'delete_city',
                'view_city'
            ],
            //end city permissions

            //start governorate permissions
//           'locations'=>[
//                'create_governorate',
//                'edit_governorate',
//                'delete_governorate',
//                'view_governorate'
//           ],
            //end governorate permissions

            //start employee permissions
            'employee'=>[
                'create_employee',
                'edit_employee',
                'delete_employee',
                'view_employee'
            ],
            //end employee permissions

            //start client permissions
            'clients'=>[
                'create_client',
                'edit_client',
                'delete_client',
                'view_client'
            ],
            //end client permissions

            //start center permissions
            'centers'=>[
                'create_center',
                'edit_center',
                'delete_center',
                'view_center'
            ],
            //end center permissions

            //start packages permissions
            'packages'=>[
                'create_package',
                'edit_package',
                'delete_package',
                'view_package'
            ],
            //end packages permissions

            //start devices permissions
            'devices_and_center_devices'=>[
                'create_device',
                'edit_device',
                'delete_device',
                'view_device'
            ],
            //end devices permissions

            //start reservations permissions
            'reservations'=>[
                'create_reservation',
                'edit_reservation',
                'delete_reservation',
                'view_reservation'
            ],
            //end reservations permissions

            //start doctors permissions
            'doctors'=>[
                'create_doc,tor',
                'edit_doctor',
                'delete_doctor',
                'view_doctor'
            ],
            //end doctors permissions

            //start categories permissions
            'categories'=>[
                'create_category',
                'edit_category',
                'delete_category',
                'view_category'
            ],
            //end categories permissions

            //start sliders permissions
            'sliders'=>[
                'create_slider',
                'edit_slider',
                'delete_slider',
                'view_slider'
            ],
            //end sliders permissions

            //start coupons permissions
            'coupons'=>[
                'create_coupon',
                'edit_coupon',
                'delete_coupon',
                'view_coupon'
            ],
            //end coupons permissions

            //start products permissions
            'products'=>[
                'create_product',
                'edit_product',
                'delete_product',
                'view_product'
            ],
            //end products permissions

            //start cancel_reasons permissions
            'cancel-reasons'=>[
                'create_cancel_reason',
                'edit_cancel_reason',
                'delete_cancel_reason',
                'view_cancel_reason'
            ],
            //end cancel_reasons permissions

            //start center_devices permissions
            'devices_and_center_devices'=>[
                'create_center_device',
                'edit_center_device',
                'delete_center_device',
                'view_center_device'
            ],
            //end center_devices permissions

            //start orders permissions
            'orders'=>[
                'create_order',
                'edit_order',
                'delete_order',
                'view_order'
            ],
            //end orders permissions

            //start settings permissions
            'settings'=>[
                'view_settings',
                'edit_general_settings',
                'edit_points_settings',
                'edit_terms_and_conditions_settings',
                'edit_social_media_settings',
                'edit_schedule_fcm_settings',
                ],
            //end settings permissions

            //start invoices permissions
            'invoices_and_reports'=>[
                'create_invoice',
                'edit_invoice',
                'delete_invoice',
                'view_invoice',
            ],
            //end invoices permissions


        ];
        $user = User::find(1);
        foreach($permissions as $key=>$permission)
        {
            foreach ($permission as $item){
                Permission::create(['guard_name'=>'web','category'=>$key,'name'=>$item]);
                $user->givePermissionTo($item);
            }
        }
    }
}
