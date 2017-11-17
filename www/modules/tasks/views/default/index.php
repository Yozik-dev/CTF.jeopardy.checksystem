<?php

use app\modules\tasks\widgets\TasksListWidget;
use app\modules\tasks\widgets\TasksListWidget2;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задания';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/css/metro.css");
?>

<div class="legend-paper">
    <div>Люди сплотились в борьбе за свою жизнь, за продолжение человеческой цивилизации.</div>
    <div>Битва уже началась. Впереди  8 часов! В ваших силах изменить ход предсказанного события - конца великой цивилизации Египта.</div>
</div>

<?php
    echo TasksListWidget2::widget([
        'data' => $data,
        'solved_tasks' => Yii::$app->user->identity->getSolvedTasks()
    ]);
?>
