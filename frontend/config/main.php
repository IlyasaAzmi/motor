<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Front',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
    		'user' => [
    			// following line will restrict access to admin controller from frontend application
    			'as frontend' => 'dektrium\user\filters\FrontendFilter',
    		],
  	],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@frontend/views/user'
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        // 'user' => [
        //     'identityClass' => 'common\models\User',
        //     'enableAutoLogin' => true,
        //     'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        // ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'formatter' => [
          'class' => 'yii\i18n\Formatter',
          'currencyCode' => 'Rp',
          'dateFormat' => 'php:D, d-M-Y',
          // 'datetimeFormat' => 'dd-MMMM-Y H:i:s',
          'datetimeFormat' => 'php:D, d-M-Y H:i:s',
          // 'timeFormat' => 'php: H:i',
          'defaultTimeZone' => 'Asia/Jakarta',
          'booleanFormat' => ['<span class="glyphicon glyphicon-remove"></span> No', '<span class="glyphicon glyphicon-ok"></span> Yes'],
        ],

        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => [
          $params,
          'icon-framework' => 'fa',
    ]
];
