<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Создать команду';
$this->params['breadcrumbs'][] = ['label' => 'Участники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
$this->registerJs("
    var rand = function (str) {
        return str[Math.floor (Math.random () * str.length)];
    };

    var get = function (source, len, a) {
        for (var i = 0; i < len; i++)
            a.push (rand (source));
        return a;
    };

    var alpha  = function (len, a) {
        return get ('A1BCD2EFG3HIJ4KLM5NOP6QRS7TUV8WXY9Z', len, a);
    };
    var symbol = function (len, a) {
        return get ('-:;_$!', len, a);
    };

    jQuery('#password').click(function () {

        var widget = $(this);
        var target = $(widget.data ('target'));

        var length = 10;

        var l = Math.floor (length/2), r = Math.ceil (length/2);
        var ret = alpha (l, symbol (1, alpha (r, []))).join('');

        widget.val(ret);
    });
    ");
?>