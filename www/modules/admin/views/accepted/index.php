<?php

use app\modules\admin\models\search\AcceptedSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel AcceptedSearch */

$this->title = 'Accepted Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accepted-requests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Accepted Requests', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'login',
            'title',
            'created',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
