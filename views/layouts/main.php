<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Alert;

AppAsset::register($this);

$navMenuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'About', 'url' => ['/site/about']],
    ['label' => 'Contact', 'url' => ['/site/contact']],
];

if (Yii::$app->user->can('manager')) {
    $navMenuItems[] = [
        'label' => 'Manage',
        'items' => [
            ['label' => 'Aircrafts', 'url' => ['aircraft/index']],
            ['label' => 'Airlines', 'url' => ['airline/index']],
            ['label' => 'Cities', 'url' => ['city/index']],
            ['label' => 'Payment methods', 'url' => ['payment-type/index']],
            ['label' => 'Flights', 'url' => ['flight/index']],
        ],
    ];
}

$navMenuItems[] =
    Yii::$app->user->isGuest ? (
    ['label' => 'Login', 'url' => ['/site/login']]
    ) : (
        '<li>'
        . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link']
        )
        . Html::endForm()
        . '</li>'
    );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navMenuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php
            foreach(Yii::$app->session->getAllFlashes() as $type => $flash) {
                foreach ($flash as $message) {
                    echo Alert::widget([
                        'options' => [
                            'class' => 'alert-' . $type,
                        ],
                        'body' => $message,
                    ]);
                }
            }
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
