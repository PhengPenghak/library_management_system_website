<?php

namespace app\controllers;

use app\models\Booking;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ResetPassowrd;
use app\models\User;
use app\models\Vendor;
use app\models\VendorRegister;
use app\models\VendorTimeline;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * {@inheritdoc}
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->id;

        return $this->render('index', []);
    }

    public function actionChangeVendor($selected)
    {
        $model = Vendor::find()->all();
        if ($this->request->isPost) {
            $cookie = new \yii\web\Cookie([
                'name' => 'vendor',
                'value' => Yii::$app->request->post('vendor_id')
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('_change_vendor', [
            'model' => $model,
            'selected' => $selected
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'guest_layout';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
     * Displays about page.
     *
     * @return string
     */
    public function actionResetPassword()
    {
        Yii::$app->view->params['controller_group'] = 'setting';
        $model = new ResetPassowrd();
        if ($model->load($this->request->post())) {
            if (!empty($model->new_password) && !empty($model->secret_code) && strtolower($model->secret_code) == 'master') {
                $vendorModel = Vendor::findOne($model->vendor_id);
                $vendorUser = User::findOne(['role_id' => 2, 'id' => $vendorModel->user_id]);
                $vendorUser->setPassword($model->new_password);
                $vendorUser->save();

                VendorTimeline::addTimeline(['vendor_id' => $model->vendor_id, 'action' => 'reset_password']);
            }
            Yii::$app->session->setFlash('success', "Password was reset!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('reset_password', ['model' => $model]);
    }

    public function actionAddElement()
    {
        return $this->renderAjax('_add_element', []);
    }
}
