<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Участники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать команду', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model) {
            return $model->isGuest() ? ['class' => 'info'] : [];
        },
        'columns' => [
            'id',
            [
                'attribute' => 'admin',
                'format' => 'raw',
                'value' => function ($data){ return $data->roleText(); }

            ],
            'login',
            'password',
            'is_guest',
            'university',
            'city',
            'logo',
            #'score',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
