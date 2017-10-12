<?php
namespace Sochat\commands;

use Sochat\Server;
use yii\console\Controller;
use Yii;

class ChatServerController extends Controller
{

    public function actionStart()
    {

    	$str = \Yii::$app->db;

        echo Yii::getAlias('@vendor/tmukherjee13/php-sochat/src/migrations');
    	// echo "<pre>";
    	// print_r($str);
    	// echo "</pre>";
    	die;
        $server = new Server;
        $server->serveForever();
    }

}
