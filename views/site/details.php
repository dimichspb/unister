<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\touchspin\TouchSpin;
use kartik\select2\Select2;
use app\models\PaymentType;
use yii\helpers\ArrayHelper;

/* @var $this \yii\base\View */
/* @var $model \app\models\Booking */

$flight = $model->flight;

$this->title = 'Confirmation';
?>

<div class="details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12">
            <h2>Flight details:</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= DetailView::widget([
                'model' => $flight,
                'attributes' => [
                    'origin.name',
                    'destination.name',
                    'departure:datetime',
                    'arrival:datetime',
                    'duration',
                    'airline.name',
                    'number',
                    'aircraft.name',
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h2>Booking details:</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin([
                'id' => 'booking-form',
                'action' => ['site/confirmation'],
                'method' => 'POST',
            ]); ?>

            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'flight_id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'adults')->widget(TouchSpin::className(), [
                'pluginOptions' => [
                    'min' => 1,
                    'step' => 1,
                    'max' => $flight->available,
                ],
            ]); ?>

            <?= $form->field($model, 'payment_type_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(PaymentType::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Choose your payment method...'],
            ]); ?>

            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Confirm', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>






