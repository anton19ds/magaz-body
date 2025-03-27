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
class FrontAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/frontStyle/reset.css',
        '/frontStyle/font.css',
        '/frontStyle/style.css',
        '/frontStyle/module-cart.css',
        '/frontStyle/media-store.css',
        '/frontStyle/slick/slick.css',
	    '/frontStyle/slick/slick-theme.css',
	    'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css',
        'css/cart-modal.css'
    ];
    public $js = [
        'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
        '/frontStyle/slick.min.js',
        'js/script.js',
        'asset/js/functions.js',
        'js/functions.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
