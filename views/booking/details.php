<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\touchspin\TouchSpin;
use kartik\select2\Select2;
use app\models\PaymentType;
use yii\helpers\ArrayHelper;

/* @var $this \yii\base\View */
/* @var $bookingModel \app\models\Booking */

$this->title = 'Booking details';
?>

<div class="details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'booking-form',
        'method' => 'POST',
    ]); ?>
    <div class="row">
        <div class="col-xs-12">
            <h2>Flight details:</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($bookingModel, 'flight_id')->hiddenInput()->label(false) ?>

            <?= DetailView::widget([
                'model' => $bookingModel->flight,
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
            <h2>User details:</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <?php if (Yii::$app->user->isGuest): ?>

            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($bookingModel, 'username')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= $form->field($bookingModel, 'password')->passwordInput() ?>
                </div>
            </div>

            <?php else: ?>

            <?= $form->field($bookingModel, 'user_id')->hiddenInput()->label(false) ?>
            <?= DetailView::widget([
                'model' => $bookingModel->user,
                'attributes' => [
                    'username',
                    'email',
                ],
            ]) ?>
            <?php endif ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h2>Booking details:</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($bookingModel, 'adults')->widget(TouchSpin::className(), [
                'pluginOptions' => [
                    'min' => 1,
                    'step' => 1,
                    'max' => $bookingModel->flight->available,
                ],
            ]); ?>

            <?= $form->field($bookingModel, 'payment_type_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(PaymentType::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Choose your payment method...'],
            ]); ?>

            <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i> Confirm', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>






