<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <img src="/img/users/<?= $user->image ?>" alt="no-name.png" width="250px">

        </div>
    </div>
    <div class="row">
<!--        <form action="/main/update-profile" method="post" enctype="multipart/form-data">-->
<!--            <label for="file">Файл</label><br>-->
<!--            <input type="file" name="file">-->
<!--            <br>-->
<!--            <input type="hidden" name="_csrf" value="--><?php //= Yii::$app->request->csrfToken ?><!--">-->
<!--            <label for="email">Email</label><br>-->
<!--            <input class="fields_profile" type="text" name="email" value="--><?php //= $user->email ?><!--"><br>-->
<!--            <label for="username">Username</label><br>-->
<!--            <input class="fields_profile" type="text" name="username" value="--><?php //= $user->username ?><!--"><br>-->
<!--            <label for="password">Password</label><br>-->
<!--            <input class="fields_profile" type="password" name="password"><br>-->
<!--    </div>-->
<!--    <input type="submit" name="submit" value="Отправить" class="btn btn-primary">-->
<!--    </form>-->
    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin([ 'id' => 'upload-form','options' =>[
                'method' => 'post',
                'action' => '/main/profile',
                'enctype' => 'multipart/form-data'
            ]]); ?>
            <?= $form->field($model, 'imageFile[]')->fileInput(['accept' => 'image/*']) ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => $user->username]) ?>
            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'autofocus' => true, 'value' => $user->email]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>