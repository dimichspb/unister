<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use app\models\Flight;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FlightForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $chooseModel app\models\ChooseForm */

$this->title = 'Search results';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="search-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <?php $form = ActiveForm::begin([
            'id' => 'choose-form',
            'action' => ['booking/details'],
            'method' => 'POST',
        ]) ?>
        <?= $form->field($chooseModel, 'adults')->hiddenInput()->label(false) ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'origin.name',
                'destination.name',
                'departure:datetime',
                'arrival:datetime',
                'duration',
                [
                    'attribute' => 'airline.name',
                    'value' => function(Flight $model) {
                        return $model->airline->name;
                    },
                    'visible' => Yii::$app->user->can('manager'),
                ],
                [
                    'attribute' => 'aircraft.name',
                    'value' => function(Flight $model) {
                        return $model->aircraft->name;
                    },
                    'visible' => Yii::$app->user->can('manager'),
                ],
                [
                    'attribute' => 'number',
                    'value' => function(Flight $model) {
                        return $model->airline->icao . '-' . $model->number;
                    },
                ],
                'available',
                'price:currency',
                [
                    'label' => 'Total cost',
                    'value' => function(Flight $model) use ($chooseModel) {
                        return Yii::$app->formatter->asCurrency($chooseModel->adults * $model->price);
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{book}',
                    'buttons' => [
                        'book' => function ($url, Flight $model) {
                            if (!Yii::$app->user->isGuest && $model->checkUserBooking(Yii::$app->user->getIdentity())) {
                                return 'booked';
                            }

                            return Html::submitButton('<i class="glyphicon glyphicon-shopping-cart"></i> Book now', ['class' => 'btn btn-primary', 'name' => 'ChooseForm[flight_id]', 'value' => $model->id]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
