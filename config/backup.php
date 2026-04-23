<?php

return [

    'path' => storage_path() . '/dumps/',

    'mysql' => [
        'dump_command_path' => 'docker exec -i erp-mysql ',
        'restore_command_path' => 'docker exec -i erp-mysql ',
    ],

    's3' => [
        'path' => ''
    ],

    'dropbox' => [
        'accessToken' => env('DROPBOX_ACCESS_TOKEN',''),
        'appSecret' => env('DROPBOX_APP_SECRET',''),
        'prefix' => env('DROPBOX_PREFIX','')
    ],

    'encrypt' => [
        'key' => env('ENCRYPT_KEY','')
    ],
    'compress' => false,
];
