<?php

$links = [
    public_path('storage') => storage_path('app/public'),
];

if (file_exists(public_path('legacy/www'))) {
    $links = $links + [
        public_path('legacy/www/assets') => resource_path('legacy/www/assets'),
        public_path('legacy/www/glyphicons') => resource_path('legacy/www/glyphicons'),
        public_path('legacy/www/qwoffice/bootstrap') => resource_path('legacy/www/qwoffice/bootstrap'),
        public_path('legacy/www/qwoffice/css') => resource_path('legacy/www/qwoffice/css'),
        public_path('legacy/www/qwoffice/fonts') => resource_path('legacy/www/qwoffice/fonts'),
        public_path('legacy/www/qwoffice/js') => resource_path('legacy/www/qwoffice/js'),
        public_path('legacy/www/qwoffice/estimates') => resource_path('legacy/www/qwoffice/estimates'),
        public_path('legacy/www/qwoffice/static') => resource_path('legacy/www/qwoffice/static'),
        public_path('legacy/www/qwoffice/themes') => resource_path('legacy/www/qwoffice/themes'),
        public_path('legacy/www/qwoffice/chromeless_35.js') => resource_path('legacy/www/qwoffice/chromeless_35.js'),
    ];
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => $links,

];
