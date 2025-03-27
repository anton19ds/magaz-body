<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    //'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'layout' => 'front-page',
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@', '?'],
            //'access' => ['administrator'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@web',
                    'basePath' => '@webroot',
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
            'layout' => 'main',
        ],
        'gridviewKartik' =>  [
            'class' => \kartik\grid\Module::class,
        ],
        'gridview' =>  [
            'class' => \kartik\grid\Module::class,
        ],
    ],
    'components' => [
        'shortcodes' => [
            'class' => 'tpoxa\shortcodes\Shortcode',
            'callbacks' => [
                'password' => ['app\widgets\PasswordShortcode', 'widget'],
                'userData' => ['app\widgets\UserData', 'widget'],
                'order_id' => ['app\widgets\OrderId', 'widget'],
                'anothershortcode'=>function($attrs, $content, $tag){
                    echo 'anothershortcode';
                    //return '123';
                    //if($tag == 'order_id'){
                        //debug($content);
                    //}
                },
            ]
        ],
        'mailer' => [
            'class' => "yii\swiftmailer\Mailer",
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => 'anticandida.com@gmail.com',
                'password' => 'foczpdbwvjqmvhhw',
                'encryption' => 'tls'
            ]
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
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
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],


        

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => ['_GET', '_POST'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '/<lang>/qaring/test-yandex' => 'qaring/test-yandex',
                '/<lang>/sets-data' => 'qaring/sets-data',
                '/api/check-promo'  => 'api/check-promo',
                '/api/get-product' => 'api/product-data',
                '/api/product-info' => 'api/product-info',
                '/api/info-snipet' => 'api/info-snipet',
                '/api/map-site' => 'api/map-site',
                '/ajax/link-new' => '/ajax/link-new',
                '/<lang>/gbpay' => 'qaring/gbpay',
                '/user/update-step' => 'user/info-product/update-step',
                '/load-reviews' => 'product/load-reviews',
                "/<lang>/payment-success" => "payment/success",
                "/<lang>/payment-callback/v1/webhook" => "payment/payment-callback",
                "/<lang>/payment-error" => "payment/error",
                "/payment-result" => "payment/result",
                "/payment-fail" => "payment/fail",
                '/close-order' => 'user/default/close-order',
                '/send-form-benefit' => 'user/affiliate-program/send-form-benefit',
                "/form-bonus" => "user/bonus/form-bonus",
                '/form-password' => "user/info/check-password",
                '/remove-user-adress' => 'user/info/remove-user-adress',
                '/logout' => 'login/logout',
                '/delete-promo'=> 'user/affiliate-program/delete-promo',
                '/test' => 'site/test',
                '/admin' => 'admin/orders/index',
                '/admin/<controller>' => 'admin/<controller>/index',
                '/elfinder/<a>' => 'elfinder/<a>',
                '/admin/<controller>/<action:[0-9a-zA-Z_\-]+>' => 'admin/<controller>/<action>',
                'GET,POST controller:elfinder/' => '/',
                '/cart/add-cart' => 'cart/add-cart',
                '/cart/plus-tov' => 'cart/plus-tov',
                '/cart/minus-tov' => 'cart/minus-tov',
                '/cart/cart-data' => 'cart/cart-data',
                '/cart/coupon' => 'cart/coupon',
                '/insurance/add-insurance' => 'insurance/add-insurance',
                '/insurance/delete-insurance' => 'insurance/delete-insurance',
                '/cart/promocod' => 'cart/promocod',
                '/cart/remove-tovar-from-cart' => 'cart/remove-tovar-from-cart',
                '/cart/payment-final' => 'cart/payment-final',
                '/cart/add-promocode' => 'cart/add-promocode',
                '/cart/send-order' => 'cart/send-order',
                '/cart/send-del' => 'cart/send-del',
                '/cart/send-pay' => 'cart/send-pay',
                '/cart-data/del' => 'cart/delivery',
                '/login/validate' => 'login/validate',
                '/login/register-validate' => 'login/register-validate',
                '/login/register' => 'ajax/registration',
                '/login/recover-pass' => '/login/recover-pass',
                '/<lang>' => 'site/index',
                '/<lang>/intellect-payment' => 'cart/intellect-payment',
                '/<lang>/telegram' => 'site/telegram',
                '/<lang>/telegram-ru' => 'telegram/index',
                //'/<lang>/telegram-ru' => 'telegram/main',
                '/<lang>/telegram-update' => 'site/telegram-update',
                '<lang>/strip-payment' => 'strip-payment/index',
                '/<lang>/hook' => 'site/hook',
                '/<lang>/cart' => 'cart/index',
                '/<lang>/order' => 'cart/order',
                '/<lang>/delivery' => 'cart/delivery',
                '/<lang>/payment' => 'cart/payment',
                '/<lang>/final-payment' => 'cart/final-payment',
                '/<lang>/payment-inteleckt-succes' => 'cart/payment-inteleckt-succes',
                '/<lang>/payment-card-succes' => 'cart/payment-card-succes',
                '/<lang>/payment-trisby-succes' => 'cart/payment-trisby-succes',
                '/<lang>/yandex' => 'cart/yandex',
                '/<lang>/webpay' => 'cart/webpay',
                '/<lang>/login' => 'login/index',
                '/<lang>/logout' => 'login/logout',
                '/<lang>/user' => 'user/info-product/index',
                '/<lang>/user/order' => 'user/default/index',
                '/<lang>/user/order/<order>' => 'user/default/order',
                '/<lang>/user/affiliate-program' => 'user/affiliate-program/index',
                '/<lang>/user/analytics' => 'user/affiliate-program/analytics',
                '/<lang>/user/balance' => 'user/affiliate-program/balance',
                '/<lang>/user/report' => 'user/affiliate-program/report',
                '/<lang>/user/feedback' => 'user/feedback/index',
                '/<lang>/user/bonus' => 'user/bonus/index',
                '/<lang>/user/info-product/<product>' => 'user/info-product/view',
                '/<lang>/user/view/<product>' => 'user/info-product/pre-view',
                '/<lang>/user/info-product/list/<product>' => 'user/info-product/list',
                '/<lang>/user/info-product/list/<product>/<step>' => 'user/info-product/step',
                '/<lang>/user/<controller>' => 'user/<controller>/index',
                '/<lang>/user/<controller>/<action:[0-9a-zA-Z_\-]+>' => 'user/<controller>/<action>',
                '/<lang>/p/<promocode>' => 'site/promocode',
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
        //'allowedIPs' => ['*', '176.52.113.238'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['176.52.114.186', '::1'],
    ];

    //unset($config['components']['cache']);

}
//unset($config['components']['cache']);
return $config;