<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\tasks\models\tasks;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'visible')->checkbox() ?>

    <?= $form->field($model, 'answer')->textInput() ?>

    <?= $form->field($model, 'checker_name')->dropDownList(Tasks::getCheckers(),['prompt'=>'']) ?>

    <?= $form->field($model, 'category')->dropDownList(Tasks::getCategories(),['prompt'=>'']) ?>

    <?= $form->field($model, 'position')->textInput()->input("number") ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
