<?php

use yii\helpers\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teams-create row">

    <div class="col-md-10 col-md-offset-1">

        <div class="text-center">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
