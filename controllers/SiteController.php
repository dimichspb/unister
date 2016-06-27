<?php

namespace app\controllers;

use app\models\ChooseForm;
use app\models\FlightForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Flight;
use app\models\Booking;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'details'],
                'rules' => [
                    [
                        'actions' => ['logout', 'details'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'search' => ['get'],
                    'details' => ['post'],
                    'confirmation' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new FlightForm();
        $model->adults = empty($model->adults)? 1: $model->adults;


        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionSearch()
    {
        $model = new FlightForm();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        if ($dataProvider->getCount() === 0) {
            Yii::$app->session->addFlash('info', 'Sorry, no flight found by your criteria');
            return $this->redirect(['site/index']);
        }

        $chooseModel = new ChooseForm();
        $chooseModel->adults = $model->adults;

        return $this->render('search', [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
            'chooseModel' => $chooseModel,
        ]);
    }

    public function actionDetails()
    {
        $model = new ChooseForm();
        $model->load(Yii::$app->request->post());

        $bookModel = new Booking();
        $bookModel->adults = $model->adults;
        $bookModel->flight_id = $model->flight_id;
        $bookModel->user_id = Yii::$app->user->getId();

        return $this->render('details', [
            'model' => $bookModel,
        ]);

    }

    public function actionConfirmation()
    {
        $model = new Booking();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('confirmation');
        }
        Yii::$app->session->addFlash('danger', 'Sorry, you cannot book the same flight twice');
        return $this->goBack();
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
