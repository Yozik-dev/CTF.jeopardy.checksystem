<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ExtraPoints */

$this->title = 'Create Extra Points';
$this->params['breadcrumbs'][] = ['label' => 'Extra Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extra-points-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
