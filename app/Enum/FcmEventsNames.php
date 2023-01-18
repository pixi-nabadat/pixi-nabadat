<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'CREATE_NEW_ORDER'              =>'create new order',
        'CHANGE_ORDER_STATUS'           =>'create new order',
        'CREATE_USER_RESERVATION'       =>'create new order',
        'CANCEL_CENTER_RESERVATION'     =>'create new order',
        'COMPLETE_USER_RESERVATION'     =>'create new order',
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

    public static array $FLAGS = [
        'USER_NAME'=>'@USER_NAME@',
        'NUMBER_OF_NABADAT'=>'@NUMBER_OF_NABADAT@',
        'EXPIRE_DATE'=>'@EXPIRE_DATE@',
        'ORDER_NUMBER'=>'@ORDER_NUMBER@',
        'ORDER_STATUS'=>'@ORDER_STATUS@',
        'RESERVATION_NUMBER'=>'@RESERVATION_NUMBER@',
        'RESERVATION_STATUS'=>'@RESERVATION_STATUS@',
    ];
}
