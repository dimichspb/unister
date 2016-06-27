<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use app\models\City;
use app\models\Airline;
use app\models\Aircraft;

/* @var $this yii\web\View */
/* @var $model app\models\Flight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flight-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'origin_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
    ]) ?>

    <?= $form->field($model, 'destination_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
    ]) ?>

    <?= $form->field($model, 'departure')->widget(DateTimePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'arrival')->widget(DateTimePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'airline_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Airline::find()->all(), 'id', 'name'),
    ]) ?>

    <?= $form->field($model, 'aircraft_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Aircraft::find()->all(), 'id', 'name'),
    ]) ?>

    <?= $form->field($model, 'number')->widget(MaskedInput::className(), [
        'mask' => '9999',
    ]) ?>

    <?= $form->field($model, 'seats')->widget(MaskedInput::className(), [
        'mask' => '999',
    ]) ?>

    <?= $form->field($model, 'price')->widget(MaskedInput::className(), [
        'mask' => '99999.99',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
