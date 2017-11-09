<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AcceptedRequests */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accepted Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accepted-requests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user.login',
            'task_id',
            'task.title'
        ],
    ]) ?>

</div>
