<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FlightSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flight-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'origin_id') ?>

    <?= $form->field($model, 'destination_id') ?>

    <?= $form->field($model, 'departure') ?>

    <?= $form->field($model, 'arrival') ?>

    <?php // echo $form->field($model, 'airline_id') ?>

    <?php // echo $form->field($model, 'aircraft_id') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'seats') ?>

    <?php // echo $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
