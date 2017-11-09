<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AcceptedRequests */

$this->title = 'Create Accepted Requests';
$this->params['breadcrumbs'][] = ['label' => 'Accepted Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accepted-requests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
