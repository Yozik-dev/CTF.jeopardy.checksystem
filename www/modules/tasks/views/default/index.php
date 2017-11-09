<?php

use app\modules\tasks\widgets\TasksListWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задания';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/css/metro.css");
?>

<div class="legend-paper basis matrix-cursor">
    <div>> Срочная сводка: была зафиксирована обширная вспыша вокруг недосягаемой планеты-гиганта! Там что-то произошло! </div>
    <div>Необходимо срочно подготовить экспедицию туда, для разведки! Медлить нельзя, потому что инновационная технология добычи руды из окружающего газового пространства явно не оказалась рентабильной, а строить звездолёты из чего-то надо. Отправлять живые оргнаизмы в столь рискованное дело слишком опасно, поэтому возложим эту ответственную миссию на новые корабли SH7890, для разработки которых были применены самые современные технологии искусственного интеллекта.</div>
    <div>Таким образом рассуждали цивилизации на каждой планете звездной системы RT81X/01. Кажется, может завязаться отличная "схватака за ресурсы" -- все уселись поудобнее перед своими экранами? Тогда, "Поехали!"</div>
</div>

<?php
    echo TasksListWidget::widget([
        'tasks' => $dataProvider->getModels(),
        'tasks_count' => $dataProvider->getTotalCount(),
        'solved_tasks' => Yii::$app->user->identity->getSolvedTasks()
    ]);
?>