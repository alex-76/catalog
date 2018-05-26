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
        'css/plagins/autocomplete.css',
        'css/site.css',
    ];
    public $js = [
        'js/plagins/jquery.cookie.js',
        'js/plagins/jquery.accordion.js',
        'js/plagins/jquery.autocomplete.js',
        'js/main.js',
        'js/plagins/jquery.nicescroll.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
