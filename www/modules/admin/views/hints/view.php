<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Hints */

$this->title = $model->task->title . " #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hints-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить подсказку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'task.title',
            'content',
            'visible',
        ],
    ]) ?>

</div>
