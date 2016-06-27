<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Flight;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FlightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flight-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Flight', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'origin.name',
            'destination.name',
            'departure.datetime',
            'arrival.datetime',
            [
                'attribute' => 'airline_id',
                'value' => function(Flight $model) {
                    return $model->airline->name;
                },
                'visible' => Yii::$app->user->can('manager'),
            ],
            [
                'attribute' => 'aircraft_id',
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
            [
                'attribute' => 'seats',
                'visible' => Yii::$app->user->can('manager'),
            ],
            'available',
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
