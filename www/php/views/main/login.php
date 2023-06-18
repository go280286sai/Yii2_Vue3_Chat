<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="container pt-5 pb-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для входа заполните следующие поля:</p>

    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'method' => 'post',
                'action' => '/main/get-user',
            ]); ?>
            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <div>
                    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
<?= Html::a('Зарегистрироваться', '/main/register') ?>
        </div>
    </div>
</div>
