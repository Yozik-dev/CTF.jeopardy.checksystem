<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Users;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>
            Html::img('/images/logo.png', ['align'=>"left", 'class'=>'brand-logo']) .
            Html::beginTag('div', ['class'=>'brand-text']) .
            'Всероссийские межвузовские соревнования<br>по защите информации'.
            Html::endTag('div'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_ADMIN) ?
                ['label' => 'Главная', 'url' => ['/admin/default/control']] : ['label' => 'Главная', 'url' => ['/']],

            (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_ADMIN) ?
                ['label' => 'Пользователи', 'url' => ['/admin/users/index']] : '',

            (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_USER)?
                ['label' => 'Задания', 'url' => ['/tasks/default/index']] : '',
            (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_ADMIN) ?
                ['label' => 'Задания', 'url' => ['/admin/tasks/index']] : '',

            #(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_USER)?
            #    ['label' => 'Подсказки', 'url' => ['/hints/']] : '',
            (!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == Users::ROLE_ADMIN) ?
                ['label' => 'Подсказки', 'url' => ['/admin/hints/index']] : '',

            ['label' => 'Результаты', 'url' => ['/site/scoreboard']],
            ['label' => 'Помощь', 'url' => ['/site/about']],
            ['label' => 'Легенда', 'url' => ['/site/legend']],
            Yii::$app->user->isGuest ?
                ['label' => 'Вход', 'url' => ['/auth']] :
                [
                    'label' => 'Выход (' . Yii::$app->user->identity->login . ')',
                    'url' => ['/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Yozik <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
