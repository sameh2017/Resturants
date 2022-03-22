<?php
return [
    "statusCodes" =>[
            'authorised' => 1,
            'decline' => 2,
            'refunded' => 3,

        ],

    "providres" =>[
        'DataProviderX', 'DataProviderY'
    ],

    "dataMap" =>[
        'DataProviderX'=>[
            'statusCode'=> 'statusCode',
            'parentAmount'=> 'parentAmount',
            'Currency'=> 'Currency',
            'parentIdentification' => 'parentIdentification' ,
            'registerationDate' => 'registerationDate' ,
        ] ,
        'DataProviderY'=>[
            'statusCode'=> 'status',
            'parentAmount'=> 'balance',
            'Currency'=> 'currency',
            'parentIdentification' => 'id' ,
            'registerationDate' => 'created_at' ,
        ]

    ]


];
