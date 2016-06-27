<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AircraftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aircrafts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aircraft-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Yii::$app->user->can('manager')): ?>
    <p>
        <?= Html::a('Create Aircraft', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'icao',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('manager')? '{view} {update} {delete}': '{view}',
            ],
        ],
    ]); ?>
</div>
