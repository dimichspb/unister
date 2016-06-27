<?php

use app\models\FlightForm;
use app\models\City;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\FlightForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'flight-form',
    'action' => ['search'],
    'method' => 'GET',
    'options' => ['class' => 'form-horizontal'],
]); ?>

<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'origin_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'destination_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Choose your destination....'],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'departure')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy',
            ],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'adults')->widget(TouchSpin::className(), [
            'pluginOptions' => [
                'min' => 1,
                'step' => 1,
            ],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-center">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Search', ['class' => 'btn btn-default', 'name' => 'search-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
