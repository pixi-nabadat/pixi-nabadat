<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'EXPIRE_POINTS_BEFORE_1'        =>'expire_points_before_one_day',
        'EXPIRE_POINTS_BEFORE_3'        =>'expire_points_before_three_day',
        'EXPIRE_POINTS_BEFORE_7'        =>'expire_points_before_seven_day',

        'ONE_DAY_BEFORE_RESERVATION'    =>'one_day_before_reservation',
        'TWO_DAYS_BEFORE_RESERVATION'   =>'two_days_before_reservation',

        'NABADAT_NOT_USED_FOR_3'        =>'nabadat_not_used_for_3_days',
        'NABADAT_NOT_USED_FOR_7'        =>'nabadat_not_used_for_7_days',
        'NABADAT_NOT_USED_FOR_11'       =>'nabadat_not_used_for_11_days',
        
        'USER_PACKAGE_EXPIRE_REMINDER'       =>'user_package_expire_reminder',
    ];

    public static array $FCMACTIONS = [
        'CREATE_NEW_ORDER'              =>'create_new_order',
        'CHANGE_ORDER_STATUS'           =>'change_order_status',
        'CREATE_USER_RESERVATION'       =>'create_user_reservation',
        'CHANGE_RESERVATION_STATUS'     =>'change_reservation_status',
        'COMPLETE_USER_RESERVATION'     =>'complete_user_reservation',
        'DEAL_WITH_NEW_CENTER'          =>'deal_with_new_center',
        'CENTER_CREATE_NEW_OFFER'       =>'center_create_new_offer',
        'CREATE_NEW_COUPON_DISCOUNT'    =>'create_new_coupon_discount',

    ];

    public static array $FLAGS = [
        '@USER_NAME@'=>'@USER_NAME@',
        '@NUMBER_OF_NABADAT@'=>'@NUMBER_OF_NABADAT@',
        '@EXPIRE_DATE@'=>'@EXPIRE_DATE@',
        '@ORDER_NUMBER@'=>'@ORDER_NUMBER@',
        '@ORDER_STATUS@'=>'@ORDER_STATUS@',
        '@RESERVATION_NUMBER@'=>'@RESERVATION_NUMBER@',
        '@RESERVATION_STATUS@'=>'@RESERVATION_STATUS@',
        '@CENTER_NAME@'=>'@CENTER_NAME@',
        '@CENTER_LOCATION@'=>'@CENTER_LOCATION@',
        '@COUPON_CODE@'=>'@COUPON_CODE@',
        '@COUPON_DISCOUNT@'=>'@COUPON_DISCOUNT@',
        '@COUPON_END_DATE@'=>'@COUPON_END_DATE@',
        '@COUPON_MIN_BUY@'=>'@COUPON_MIN_BUY@',
    ];

    public static array $CHANNELS = [
        'sms'=>'sms',
        'fcm'=>'fcm',
        'mail'=>'mail',
    ];
}