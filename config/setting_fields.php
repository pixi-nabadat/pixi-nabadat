<?php
return [
    'general' => [
        'title' => 'General',
        'desc' => 'All the general settings for application.',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'company_name_ar', // unique name for field
                'label' => 'Company Name Ar', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'company_name_en', // unique name for field
                'label' => 'Company Name En', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'company_logo', // unique name for field
                'label' => 'Company Logo', // you know what label it is
                'rules' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'address', // unique name for field
                'label' => 'Address', // you know what label it is
                'rules' => 'required|string', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'location_id', // unique name for field
                'label' => 'Location', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'js-example-basic-single col-sm-12', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'phone', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'primary_phone', // unique name for field
                'label' => 'Primary Phone', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'phone', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'phone2', // unique name for field
                'label' => 'Phone 2', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'phone', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'phone3', // unique name for field
                'label' => 'Phone 3', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'phone', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'phone4', // unique name for field
                'label' => 'Phone 4', // you know what label it is
                'rules' => 'required|string|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'description', // unique name for field
                'label' => 'Description', // you know what label it is
                'rules' => 'required|string', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'max_size_uploaded', // unique name for field
                'label' => 'Max Size Uploaded', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'avg_waiting_time', // unique name for field
                'label' => 'Average Waiting Time', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '' // default value if you want
            ],
        ]
    ],
    'terms_and_conditions' => [

        'title' => 'Terms & Conditions',
        'desc' => 'Manage Terms And Conditions Settings',
        'icon' => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'terms_and_conditions', // unique name for field
                'label' => 'Terms And Conditions', // you know what label it is
                'rules' => 'required|string', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            
        ]
    ],
    'social_media' => [

        'title' => 'Social Media',
        'desc' => 'Manage Social Media Settings',
        'icon' => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type' => 'url', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'facebook', // unique name for field
                'label' => 'Facebook', // you know what label it is
                'rules' => 'required|url', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'url', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'whatsapp', // unique name for field
                'label' => 'WhatsApp', // you know what label it is
                'rules' => 'required|url', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'url', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'twitter', // unique name for field
                'label' => 'Twitter', // you know what label it is
                'rules' => 'required|url', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'url', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'youtube', // unique name for field
                'label' => 'Youtube', // you know what label it is
                'rules' => 'required|url', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            
        ]
    ],
    'points' => [

        'title' => 'Points',
        'desc' => 'Manage Points Settings',
        'icon' => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type' => 'number', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'patient_points_per_pound', // unique name for field
                'label' => 'Patient Point Per Pound', // you know what label it is
                'rules' => 'required|numeric', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'patient_points_expire_days_count', // unique name for field
                'label' => 'Patient Points Expire Days Count', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'center_points_per_pound', // unique name for field
                'label' => 'Center Point Per Pound', // you know what label it is
                'rules' => 'required|numeric', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'center_points_expire_days_count', // unique name for field
                'label' => 'Center Points Expire Days Count', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'referal_points', // unique name for field
                'label' => 'Referal Points', // you know what label it is
                'rules' => 'required|numeric', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],

            [
                'type' => 'number', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'min_change_points', // unique name for field
                'label' => 'Min Number For Change Points', // you know what label it is
                'rules' => 'required|numeric', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            
        ]
    ],
    'schedule_fcm' => [

        'title' => 'Schedule Fcm',
        'desc' => 'Manage Schedule Fcm Settings',
        'icon' => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'EXPIRE_POINTS_BEFORE_1', // unique name for field
                'label' => 'Expire Points Before 1', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'EXPIRE_POINTS_BEFORE_3', // unique name for field
                'label' => 'Expire Points Before 3', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'EXPIRE_POINTS_BEFORE_7', // unique name for field
                'label' => 'Expire Points Before 7', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'NABADAT_NOT_USED_FOR_3', // unique name for field
                'label' => 'Nabadat Not Used For 3', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'NABADAT_NOT_USED_FOR_7', // unique name for field
                'label' => 'Nabadat Not Used For 7', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'NABADAT_NOT_USED_FOR_11', // unique name for field
                'label' => 'Nabadat Not Used For 11', // you know what label it is
                'rules' => 'required|integer', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
                      
        ]
    ],
];