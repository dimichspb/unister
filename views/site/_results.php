<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use app\models\Flight;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $searchModel app\models\FlightForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
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
            'class' => 'yii\grid\ActionColumn',
            'template' => '{book}',
            'buttons' => [
                'book' => function ($url, $model) {
                    return Html::submitButton('<i class="glyphicon glyphicon-shopping-cart"></i> Book now', ['class' => 'btn btn-primary']);
                },
            ],
        ],
    ],
]); ?>
