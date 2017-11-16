<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tasks\widgets\TasksListWidget;
use yii\grid\SerialColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Результаты';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => SerialColumn::className()],
        [
            'attribute' => 'logo',
            'format' => 'raw',
            'value' => function ($data){ return $data->user->getLogo(); }
        ],
        'result',
        'login',
        'university',
        'city'
    ],
]); ?>
