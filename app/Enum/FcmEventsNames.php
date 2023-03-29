<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'EXPIRE_POINTS_BEFORE_1'        =>'expire points before one day',
        'EXPIRE_POINTS_BEFORE_3'        =>'expire points before three day',
        'EXPIRE_POINTS_BEFORE_7'        =>'expire points before seven day',

        'ONE_DAY_BEFORE_RESERVATION'    =>'One day before reservation',
        'TWO_DAYS_BEFORE_RESERVATION'   =>'two days before reservation',

        'NABADAT_NOT_USED_FOR_3'        =>'nabadat not used for 3 days',
        'NABADAT_NOT_USED_FOR_7'        =>'nabadat not used for 7 days',
        'NABADAT_NOT_USED_FOR_11'       =>'nabadat not used for 11 days',
    ];

    public static array $FCMACTIONS = [
        'CREATE_NEW_ORDER'              =>'create_new_order',
        'CHANGE_ORDER_STATUS'           =>'change_order_status',
        'CREATE_USER_RESERVATION'       =>'create_user_reservation',
        'CANCEL_CENTER_RESERVATION'     =>'cancel_center_reservation',
        'COMPLETE_USER_RESERVATION'     =>'complete_user_reservation',
        'DEAL_WITH_NEW_CENTER'          =>'deal with new center',
        'CENTER_CREATE_NEW_OFFER'       =>'center create new offer',
        'CREATE_NEW_COUPON_DISCOUNT'    =>'create new coupon discount',

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