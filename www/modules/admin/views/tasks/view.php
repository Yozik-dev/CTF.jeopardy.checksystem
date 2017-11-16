<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Tasks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'id',
            'title',
            'description:ntext',
            'cost',
            'visible',
            'answer',
            [
                'attribute' => 'category',
                'format' => 'raw',
                'value' => $model->getCategoryName()
            ],
            'checker_name',
            'position',

        ],
    ]) ?>

    <?php
        #var_dump($model->userssolved);
    ?>


</div>
