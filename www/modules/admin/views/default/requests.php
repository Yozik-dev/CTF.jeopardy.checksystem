<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tasks\widgets\TasksListWidget;
use yii\grid\SerialColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запросы флагов';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'userlogin',
        'task.categoryName',
        'tasktitle',
        'task.cost',
        'answer',
        'created',
        'result'
    ],
]); ?>
