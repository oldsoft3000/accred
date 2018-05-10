<?php
namespace app\config;

use Yii;
use yii\base\BootstrapInterface;

/*
/* The base class that you use to retrieve the settings from the database
*/

class settings implements BootstrapInterface {

    private $db;

    public function __construct() {
        $this->db = Yii::$app->db;
    }

    /**
    * Bootstrap method to be called during application bootstrap stage.
    * Loads all the settings into the Yii::$app->params array
    * @param Application $app the application currently running
    */

    public function bootstrap($app) {

        Yii::$app->params['settings']['mail_reserve_from'] = 'from@domain.com';
        Yii::$app->params['settings']['mail_reserve_subject'] = '';
        Yii::$app->params['settings']['mail_reserve_text'] = '';
        Yii::$app->params['settings']['mail_reserve_html'] = '';


    }

}