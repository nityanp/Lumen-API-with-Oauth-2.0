<?php //config/auth.php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
			'driver' => 'session',
			'provider' => 'users',
		],

		'api' => [
			'driver' => 'passport',
			'provider' => 'users',
		],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\User::class
        ]
    ],
	'key' => env('APP_KEY'),
	
];