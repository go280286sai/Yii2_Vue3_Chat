<?php

namespace app\functions;

use yii\helpers\Html;

class MyFunc
{
    public static function getFilds(array $filds): array
    {
        return array_map(function ($fild) {
            return Html::encode($fild);
        }, $filds);
}
}