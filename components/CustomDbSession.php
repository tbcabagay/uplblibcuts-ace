<?php
namespace app\components;

use Yii;
use yii\db\Connection;
use yii\db\Query;
use yii\base\InvalidConfigException;
use yii\di\Instance;

class CustomDbSession extends \yii\web\DbSession {

    public $writeCallback = ['\app\components\CustomDbSession', 'writeCustomFields'];

    public function writeCustomFields($session) {

        try
        {
            $uid = (\Yii::$app->user->getIdentity(false) == null)?null:\Yii::$app->user->getIdentity(false)->id;
            return [ 'user' => $uid, 'ip_address' => $_SERVER['REMOTE_ADDR'] ];
        }
        catch(Exception $excp)
        {
            \Yii::info(print_r($excp), 'information');


        }
    }


}