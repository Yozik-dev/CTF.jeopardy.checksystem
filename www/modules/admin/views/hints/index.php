<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подсказки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hints-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать подсказку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'task.title',
                'format' => 'raw',
                'value' => function ($data){ return (isset($data->task->title))?Html::a($data->task->title, Url::to(["/admin/tasks/view", "id" => $data->task_id])):"Deleted task"; }
            ],
            'visible',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
