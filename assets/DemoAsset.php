<?php
namespace hoaaah\sbadmin2\assets;

use yii\web\AssetBundle;

/**
 * sb-StylishPortofolio AssetBundle
 */
class DemoAsset extends AssetBundle
{
    public $sourcePath='@bower/startbootstrap-sb-admin-2';
    public $baseUrl = '@web';
    
    public $css=[
    ];
    
    public $js=[
        'js/demo/chart-area-demo.js',
        'js/demo/chart-pie-demo.js'
    ];
    
    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
    
    public function init() {
        parent::init();
    }
}