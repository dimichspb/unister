<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ChooseForm;
use app\models\Flight;
use app\models\Booking;
use app\models\FlightForm;

class BookingController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['confirmation'],
                'rules' => [
                    [
                        'actions' => ['confirmation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'results' => ['get'],
                    'details' => ['post'],
                ],
            ],
        ];
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
                return $this->redirect(['booking/confirmation']);
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
}
