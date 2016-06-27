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
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Yii::$app->user->can('manager')): ?>
    <p>
        <?= Html::a('Create Flight', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

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
            [
                'attribute' => 'seats',
                'visible' => Yii::$app->user->can('manager'),
            ],
            'available',
            'price:currency',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('admin')? '{view} {update} {delete}': '{view}',
            ],
        ],
    ]); ?>
</div>
