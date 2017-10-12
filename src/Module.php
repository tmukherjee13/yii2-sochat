<?php
namespace Sochat;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

class Module extends BaseModule implements BootstrapInterface
{

    public $controllerNamespace = 'Sochat\console\controllers';
 
    public function init()
    {
        parent::init();

        // initialize the module with the configuration loaded from config.php
        \Yii::configure(Yii::$app, require (__DIR__ . '/config/config.php'));
    }
 
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'Sochat\commands';
        }
    }
}
