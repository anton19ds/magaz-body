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
class AdminAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/site.css',
    "/adminStyle/assets/css/atlantis.min.css",
    "/adminStyle/assets/css/demo.css",
    "/adminStyle/style.css"
    
  ];
  public $js = [
    // "/adminStyle/assets/js/core/jquery.3.2.1.min.js",
    "/adminStyle/assets/js/core/popper.min.js",
    "/adminStyle/assets/js/core/bootstrap.min.js",
    "/adminStyle/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js",
    "/adminStyle/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js",
    "/adminStyle/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js",
    "/adminStyle/assets/js/plugin/chart.js/chart.min.js",
    "/adminStyle/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js",
    "/adminStyle/assets/js/plugin/chart-circle/circles.min.js",
    "/adminStyle/assets/js/plugin/datatables/datatables.min.js",
    "/adminStyle/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js",
    "/adminStyle/assets/js/plugin/jqvmap/jquery.vmap.min.js",
    "/adminStyle/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js",
    "/adminStyle/assets/js/plugin/sweetalert/sweetalert.min.js",
    "/adminStyle/assets/js/atlantis.min.js",
    "/adminStyle/assets/js/setting-demo.js",
    "/adminStyle/assets/js/demo.js",
    "/adminStyle/assets/js/plugin/webfont/webfont.min.js",
    "/adminStyle/main.js"
  ];
  public $depends = [
     'yii\web\YiiAsset',
     'yii\bootstrap5\BootstrapAsset'
  ];
}