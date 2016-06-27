<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Flight */

$this->title = 'Create Flight';
$this->params['breadcrumbs'][] = ['label' => 'Flights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flight-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
