<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        // 'css/style.css',
        // 'css/cart.css',
        // 'css/appcel.css',
        // 'public/style/cart-form.css',
        // 'css/ser.css',
        // 'css/media.css',
        // 'css/reset.css',

        'css/styles.css',
        'css/ser.css',
        "asset/css/reset.css",
        "asset/css/fonts.css",
        'asset/css/media.css',
        
    ];
    public $js = [
    //   'js/script.js',
    'asset/js/functions.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
