<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class=" container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для регистрации заполните следующие поля:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'method' => 'post',
                'action' => '/main/new-register',
            ]); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <div>
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
<?= Html::a('Авторизоваться', '/main/login') ?>
        </div>
    </div>
</div>
