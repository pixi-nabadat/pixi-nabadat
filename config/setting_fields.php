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
                'name' => 'app_name', // unique name for field
                'label' => 'App Name', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => 'CoolApp' // default value if you want
            ]
        ]
    ],
    'points' => [

        'title' => 'Points',
        'desc' => 'Manage Points Settings',
        'icon' => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type' => 'number', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'point_pound', // unique name for field
                'label' => 'Point Per Pound', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => 'form-control', // any class for input
                'value' => '0' // default value if you want
            ],
            
        ]
    ],
];