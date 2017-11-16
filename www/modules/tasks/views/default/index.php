<?php

use app\modules\tasks\widgets\TasksListWidget;

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
    echo TasksListWidget::widget([
        'tasks' => $dataProvider->getModels(),
        'tasks_count' => $dataProvider->getTotalCount(),
        'solved_tasks' => Yii::$app->user->identity->getSolvedTasks()
    ]);
?>