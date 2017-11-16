<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\tasks\models\Tasks;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\AcceptedRequests */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accepted-requests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(Users::getArrayAll()) ?>

    <?= $form->field($model, 'task_id')->dropDownList(Tasks::getAllTasks()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
