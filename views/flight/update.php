<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Flight */

$this->title = 'Update Flight: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Flights', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="flight-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
