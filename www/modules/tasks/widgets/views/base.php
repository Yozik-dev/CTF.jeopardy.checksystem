<?php

/**
 * @var array $data
 * @var array $solved_tasks
 * @var \yii\web\View $this
 */
use yii\bootstrap\Html;

$jsCode = <<<JS
    $('.cat-task-opening').on('click', function() {
        var self = $(this);
        $.ajax({
            url: $(self).attr('href'),
            method: 'GET',
            dataType: 'JSON',
            success: function(data) {
                if(data['status'] && data['html']) {
                    $('#task-modal .modal-content').html(data['html']);
                    $('#task-modal').modal();
                } else {
                    window.location.replace($(self).attr('href'));
                }
            },
            error: function() {
                window.location.replace($(self).attr('href'));
            }
        });
        return false;
    });
JS;
Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);

?>


<div class="tasks-categories">
    <?php foreach ($data as $name => $tasks): ?>
        <?php $count = count($tasks); ?>
        <div class="tasks-category">
            <div class="papyrus papyrus<?= $count ?>">
                <div class="cat-title text-center">
                    <?= $name ?>
                </div>
                <div class="cat-tasks text-center">
                    <?php foreach ($tasks as $task): ?>
                        <?php $solved = isset($solved_tasks[$task['id']]); ?>
                        <?= Html::a(
                            Html::tag('div', $task['cost'] ?: Html::img('/images/war.png', ['width' => '150px']), ['class' => ['cat-task', $solved ? 'cat-task-solved' : '']]),
                            ['/tasks/view', 'id' => $task['id']],
                            ['class' => 'cat-task-opening']
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>