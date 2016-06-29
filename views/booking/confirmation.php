<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Confirmation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <strong>Congratulation! The flight has been booked successfully</strong>
    </p>

    <div class="row">
        <div class="col-xs-12 text-center">
            <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Go home', ['site/index'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>