<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <header>
        <div class="container">
            <div class="row header_body_site">
                <div class="col-6">
                    <div class="title_site">
                        <a href="/"><img class="logo_site" src="/img/Logo.png" alt=""/></a
                        ><b class="logo_text_title">YII2+Vue</b>
                    </div>
                    <div class="logo_text_title_under">Pusher chat</div>
                </div>
                <div class="col-6">
                    <div class="header_menu_site">
                        <?php
                        if (Yii::$app->session->has('user')) {
                            echo '<div><a href="/main/index">Чат</a></div>';
                            echo '<div><a href="/main/profile">Профиль</a></div>';
                        } ?>
                        <div><a href="/main/about">О нас</a></div>
                        <div><a href="/main/contact">Контакты</a></div>
                        <?php if (Yii::$app->session->has('user')) {
                            echo '<div><a href="/main/logout">Выйти</a></div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row body_site">
            <?= $content ?>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row header_body_site">
                <div class="col-2 body_menu_footer">
                    <div><a href="#">Мой профиль</a></div>
                    <div><a href="#">О нас</a></div>
                    <div><a href="#">Контакты</a></div>
                    <div><a href="#">Logout</a></div>
                </div>
                <div class="col-5 body_p">A Little Company Information !
                    Morbitincidunt maurisque eros molest nunc anteget sed vel lacus mus semper. Anterdumnullam interdum
                    eros dui urna consequam ac nisl nullam ligula vestassa. Condimentumfelis et amet tellent quisquet a
                    leo lacus nec augue
                </div>
                <div class="col-5 body_menu_list">
                    Our Contact Details
                    <ul class=" list-unstyled">
                        <li>Company Name</li>
                        <li>Street Name & Number</li>
                        <li>Town</li>
                        <li>Postcode/Zip</li>
                        <li>Tel: xxxxx xxxxxxxxxx</li>
                        <li>Fax: xxxxx xxxxxxxxxx</li>
                        <li> Email: info@domain.com</li>
                        <li>LinkedIn: Company Profile</li>
                    </ul>
                </div>
            </div>
            <div class="row author_site">
                <div class="col-6">Copyright © 2023 - All Rights Reserved - e-mail: go280286sai@gmail.com</div>
                <div class="col-6">Автор: Александр Сторчак</div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>