<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Hints */

$this->title = 'Создание подсказки';
$this->params['breadcrumbs'][] = ['label' => 'Подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hints-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
