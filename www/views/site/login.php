<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #loginform-rememberme{margin-left: -20px;}
    .field-loginform-rememberme label {text-indent: 10px;}
</style>
<div class="row">
    <div class="col-md-8">
        <div class="paper-view">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => '<div class="row">
                                    {label}
                                    <div class="col-xs-5">{input}</div>
                                    <div class="row">
                                        <div class="col-xs-5 col-xs-offset-2">{error}</div>
                                    </div>
                                    </div>',
                    'labelOptions' => ['class' => 'col-xs-2 control-label'],
                ],
            ]); ?>

                <?= $form->field($model, 'login') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="row"><div class="col-xs-offset-2 col-xs-6">{input}{label}</div></div>',
                ]) ?>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <?= Html::submitButton('Войти', [
                            'class' => 'btn btn-primary',
                            'name' => 'login-button',
                            'style' => 'margin-left: -20px']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>