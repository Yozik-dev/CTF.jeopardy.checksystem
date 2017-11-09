<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\tasks\models\Tasks;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Hints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hints-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->dropDownList(Tasks::getAllTasks()) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visible')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
