<?php

use yii\grid\GridView;

$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">Активности</div>
        <div class="panel-body">
            <a href="/admin/users"><span class="glyphicon glyphicon-user"></span> Пользователи</a><br>
            <a href="/admin/tasks"><span class="glyphicon glyphicon-tasks"></span> Задания</a><br>
            <a href="/admin/hints"><span class="glyphicon glyphicon-question-sign"></span> Подсказки</a><br>
            <a href="/admin/extrapoints/index"><span class="glyphicon glyphicon-signal"></span> Экстра баллы</a><br>
            <a href="/admin/accepted"><span class="glyphicon glyphicon-ok"></span> Решенные таски</a><br>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">Информация</div>
        <div class="panel-body">
            <a href="/admin/default/scoreboard"><span class="glyphicon glyphicon-signal"></span> Результаты (вычисляемые)</a><br>
            <a href="/scoreboard"><span class="glyphicon glyphicon-signal"></span> Результаты (кешированные)</a><br>
            <a href="/admin/default/requests"><span class="glyphicon glyphicon-flag"></span> Сдача флагов</a><br>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">Пользовательские</div>
        <div class="panel-body">
            <a href="/tasks"><span class="glyphicon glyphicon-tasks"></span> Задания</a><br>
        </div>
    </div>
</div>