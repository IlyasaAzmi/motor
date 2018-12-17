<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
    		'user' => [
      			'class' => 'dektrium\user\Module',
            'mailer' => [
                'sender'                => 'no-reply@myhost.com', // or ['no-reply@myhost.com' => 'Sender name']
                'welcomeSubject'        => 'Welcome subject',
                'confirmationSubject'   => 'Confirmation subject',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject'       => 'Recovery subject',
            ],
            'admins' => ['ilyasa'],
            'modelMap' => [
                'RegistrationForm' => 'common\models\RegistrationForm',
                'User' => 'common\models\User',
                // 'Profile' => 'common\models\Profile',
            ],

      			// you will configure your module inside this file
      			// or if need different configuration for frontend and backend you may
      			// configure in needed configs
    		],
  	],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
