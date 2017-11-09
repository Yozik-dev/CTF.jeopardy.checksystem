<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AcceptedRequests */

$this->title = 'Update Accepted Requests: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accepted Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accepted-requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
