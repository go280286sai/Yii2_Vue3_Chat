<?php

namespace app\controllers;

use app\models\Pusher;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ChatController extends Controller
{


    public function actionPusher(): string
    {
        if (Yii::$app->request->isPost) {
            $object = (Yii::$app->request->post()['body']);
            $text = Json::encode($object);
            Pusher::send($text);
            return 'ok';
        } else {
            return 'error';
        }
    }
}