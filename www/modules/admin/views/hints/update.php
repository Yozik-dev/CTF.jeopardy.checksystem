<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Hints */

$this->title = 'Обновить подсказку';
$this->params['breadcrumbs'][] = ['label' => 'Подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="hints-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
