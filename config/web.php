<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
  'id' => 'basic',
  'language' => 'ru-RU',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'controllerMap' => [
    'elfinder' => [
      'class' => 'mihaildev\elfinder\Controller',
      'access' => ['administrator'],
      'disabledCommands' => ['netmount'],
      'roots' => [
        [
          'baseUrl'=>'@web',
          'basePath'=>'@webroot',
          'path' => 'file',
          'name' => 'Файлы'
        ],
      ],
      // 'watermark' => [
      //   'source'         => __DIR__ . '/logo.png', // Path to Water mark image
      //   'marginRight'    => 5,          // Margin right pixel
      //   'marginBottom'   => 5,          // Margin bottom pixel
      //   'quality'        => 95,         // JPEG image save quality
      //   'transparency'   => 70,         // Water mark image transparency ( other than PNG )
      //   'targetType'     => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP | IMG_WEBP,// Target image formats ( bit-field )
      //   'targetMinPixel' => 200         // Target image minimum pixel size
      // ]
    ]
  ],


  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'modules' => [
    'admin' => [
      'class' => 'app\modules\admin\Module',
      'layout' => 'main',
    ],
    'user' => [
      'class' => 'app\modules\user\Module',
    ],
  ],
  'components' => [
    'i18n' => [
        'translations' => [
            'app*' => [
                'class'=>yii\i18n\PhpMessageSource::className(),
                'basePath' => '@app/messages',
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
        ],
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    'request' => [
      'baseUrl' => '',
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => 'TqkyJ2rtkFw5lzfg_kRGDl2U0g8v92Q7Ds',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'app\models\User',
      'enableAutoLogin' => true,
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
      'class' => \yii\symfonymailer\Mailer::class,
      'viewPath' => '@app/mail',
      // send all mails to a file by default.
      'useFileTransport' => true,
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
    'db' => $db,
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        // '/<lang>' => 'site/index',
        '' => 'site/index',
        // '/product' => 'site/index',
        '/admin' => 'admin/main/index',
        '/admin/<controller>' => 'admin/<controller>/index',
        '/admin/<controller>/<action:[0-9a-zA-Z_\-]+>' => 'admin/<controller>/<action>',
        'GET,POST controller:elfinder/' => '/',
        '/cart/add-cart' => 'cart/add-cart',
        '/cart/plus-tov' => 'cart/plus-tov',
        '/cart/minus-tov' => 'cart/minus-tov',
        '/cart/cart-data' => 'cart/cart-data',
        '/cart/payment' => 'cart/payment',
        '/cart/promocod' => 'cart/promocod',
        '/cart/remove-tovar-from-cart' => 'cart/remove-tovar-from-cart',
        '/cart/payment-final' => 'cart/payment-final',
        '/login/register' => 'ajax/registration',
        '/elfinder/<a>' => 'elfinder/<a>',
        '/<lang>' => 'site/index',
        '/<lang>/cart' => 'cart/index',
        '/<lang>/order' => 'cart/order',
        '/<lang>/login' => 'login/index',
        '/<lang>/logout' => 'login/logout',
        '/<lang>/user' => 'user/default/index',
        '/<lang>/user/<controller>' => 'user/<controller>/index',
        '/<lang>/user/info-product/<product>' => 'user/info-product/view',
        '/<lang>/user/view/<product>' => 'user/info-product/pre-view',
        '/<lang>/user/info-product/list/<product>' => 'user/info-product/list',
        '/<lang>/user/info-product/list/<product>/<step>' => 'user/info-product/step',
        '/<lang>/user/<controller>/<action:[0-9a-zA-Z_\-]+>' => 'user/<controller>/<action>',
        '/<lang>/<index>' => 'product/index',
        
        
    
      ],
    ],
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    'allowedIPs' => ['*', '::1'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    'allowedIPs' => ['*', '::1'],
  ];
}

return $config;