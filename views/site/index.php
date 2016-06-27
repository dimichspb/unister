<?php

/* @var $this yii\web\View */
/* @var $model app\models\FlightForm */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">You can start your flight search by filling the following form:</p>

    </div>

    <div class="body-content">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
