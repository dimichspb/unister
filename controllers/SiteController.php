<?php

namespace app\controllers;

use app\models\FlightForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
