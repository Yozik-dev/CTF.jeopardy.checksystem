<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accepted Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accepted-requests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Accepted Requests', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'user_id',
            'user.login',
            'task_id',
            'task.title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
