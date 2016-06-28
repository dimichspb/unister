<?php

namespace app\controllers;

use app\models\ChooseForm;
use app\models\FlightForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Flight;
use app\models\Booking;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'confirmation'],
                'rules' => [
                    [
                        'actions' => ['logout', 'confirmation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'results' => ['get'],
                    'details' => ['post'],
                ],
            ],
            [
                'class' => 'yii\filters\PageCache', //setting server side caching
                'only' => ['index'],
                'duration' => 600,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user->getId(), //different cache for different Users
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency', //cache updates if any changes in City table
                    'sql' => 'SELECT COUNT(*) FROM city',
                ],
            ],
            [
                'class' => 'yii\filters\HttpCache', //setting client side caching
                'only' => ['index'],
                'lastModified' => function ($action, $params) {
                    return time();
                },
                'sessionCacheLimiter' => 'public',
                'cacheControlHeader' => 'public, max-age=300',
            ],
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new FlightForm();
        $model->adults = empty($model->adults)? 1: $model->adults;

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionResults()
    {
        $model = new FlightForm();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        if ($dataProvider->getCount() === 0) {
            Yii::$app->session->addFlash('info', 'Sorry, no flight found by your criteria');
            return $this->redirect(['site/index']);
        }

        $chooseModel = new ChooseForm();
        $chooseModel->adults = $model->adults;

        return $this->render('result', [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
            'chooseModel' => $chooseModel,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionDetails()
    {
        $chooseModel = new ChooseForm();
        $bookingModel = new Booking();

        if ($chooseModel->load(Yii::$app->request->post())) {
            if (!Yii::$app->user->isGuest && $chooseModel->flight->checkUserBooking(Yii::$app->user->getIdentity())) {
                Yii::$app->session->addFlash('danger', 'Sorry, you cannot book the same flight twice');
                return $this->goBack();
            }
            $bookingModel->adults = $chooseModel->adults;
            $bookingModel->flight_id = $chooseModel->flight_id;
            $bookingModel->user_id = Yii::$app->user->isGuest? null: Yii::$app->user->getId();
        }

        if ($bookingModel->load(Yii::$app->request->post())) {
            if ($bookingModel->login() && $bookingModel->save()) {
                return $this->redirect(['site/confirmation']);
            }
        }

        return $this->render('details', [
            'bookingModel' => $bookingModel,
        ]);
    }

    /**
     * @return string
     */
    public function actionConfirmation()
    {
        return $this->render('confirmation');
    }

    /**
     * @return string|\yii\web\Response
     */
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

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
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

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
