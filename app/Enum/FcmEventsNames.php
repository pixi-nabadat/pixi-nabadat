<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'EXPIRE_POINTS_BEFORE_1'        =>'expire points before one day',
        'EXPIRE_POINTS_BEFORE_3'        =>'expire points before three day',
        'EXPIRE_POINTS_BEFORE_7'        =>'expire points before seven day',
        'CENTER_CREATE_NEW_OFFER'       =>'center create new offer',
        'DEAL_WITH_NEW_CENTER'          =>'deal with new center',
        'CREATE_NEW_COUPON_DISCOUNT'    =>'create new coupon discount',
        'NABADAT_NOT_USED_FOR_3'        =>'nabadat not used for 5 days',
        'NABADAT_NOT_USED_FOR_7'        =>'nabadat not used for 10 days',
        'NABADAT_NOT_USED_FOR_11'       =>'nabadat not used for 15 days',
    ];

    public static array $FCMACTIONS = [
        'CREATE_NEW_ORDER'              =>'create_new_order',
        'CHANGE_ORDER_STATUS'           =>'change_order_status',
        'CREATE_USER_RESERVATION'       =>'create_user_reservation',
        'CANCEL_CENTER_RESERVATION'     =>'cancel_center_reservation',
        'COMPLETE_USER_RESERVATION'     =>'complete_user_reservation',
    ];

    public static array $FLAGS = [
        '@USER_NAME@'=>'@USER_NAME@',
        '@NUMBER_OF_NABADAT@'=>'@NUMBER_OF_NABADAT@',
        '@EXPIRE_DATE@'=>'@EXPIRE_DATE@',
        '@ORDER_NUMBER@'=>'@ORDER_NUMBER@',
        '@ORDER_STATUS@'=>'@ORDER_STATUS@',
        '@RESERVATION_NUMBER@'=>'@RESERVATION_NUMBER@',
        '@RESERVATION_STATUS@'=>'@RESERVATION_STATUS@',
    ];

    public static array $CHANNELS = [
        'sms'=>'sms',
        'fcm'=>'fcm',
        'mail'=>'mail',
    ];
}