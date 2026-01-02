<?php
namespace app\commands;

use yii\console\Controller;

class UserController extends Controller
{
    public function actionHash($password)
    {
        echo \Yii::$app->security->generatePasswordHash($password) . PHP_EOL;
    }
}
