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

<div class="panel panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}",
        'rowOptions' => function($model) {
            return $model->user->isGuest() ? ['class' => 'info'] : [];
        },
        'columns' => [
            ['class' => SerialColumn::className()],
            [
                'attribute' => 'logo',
                'format' => 'raw',
                'value' => function ($data){ return $data->user->getLogo(); }
            ],
            [
                'attribute' => 'result',
                'format' => 'raw',
                'value' => function ($data){ return (isset($data->result))?$data->result:0; }
            ],
            [
                'attribute' => 'login',
                'label' => 'Команда'
            ],
            'university',
            'city'
        ],
    ]); ?>

    <?php if(!isset($_GET['blank'])): ?>
        <a href="/scoreboard?blank=show" target="_blank">Версия для мониторов</a>
    <?php endif; ?>
</div>

<script>
    setTimeout(function(){
        location.reload();
    },5000);
</script>

