<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Airline */

$this->title = 'Create Airline';
$this->params['breadcrumbs'][] = ['label' => 'Airlines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
