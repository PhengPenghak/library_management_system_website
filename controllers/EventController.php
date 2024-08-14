<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\User;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class EventController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'actions' => User::getUserPermission(Yii::$app->controller->id),
                            'allow' => true,
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['controller_group'] = 'event';
        if (in_array($action->id, ['view'])) {
            $this->layout = '_profile_detail';
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEvents()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $events = Event::find()->all();

        $eventsArray = [];
        foreach ($events as $event) {
            $eventsArray[] = [
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description,
                'id' => $event->id,
            ];
        }

        return $eventsArray;
    }

    public function actionCreate()
    {
        $model = new Event();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->title = Yii::$app->request->post('title');
            $model->description = Yii::$app->request->post('description');
            $model->start = Yii::$app->request->post('start');
            $model->end = Yii::$app->request->post('end');

            if ($model->save()) {
                Yii::$app->session->setFlash('eventCreated', 'ព្រឹត្តិការណ៍ត្រូវបានបង្កើតដោយជោគជ័យ។');
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'errors' => $model->errors];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('eventCreated', 'ព្រឹត្តិការណ៍ត្រូវបានបង្កើតដោយជោគជ័យ។');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->title = Yii::$app->request->post('title');
            $model->description = Yii::$app->request->post('description');
            $model->start = Yii::$app->request->post('start');
            $model->end = Yii::$app->request->post('end');

            if ($model->save()) {
                Yii::$app->session->setFlash('eventUpdated', 'ព្រឹត្តិការណ៍ត្រូវបានអាប់ដេតដោយជោគជ័យ។');
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'errors' => $model->errors];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('eventUpdated', 'ព្រឹត្តិការណ៍ត្រូវបានអាប់ដេតដោយជោគជ័យ។');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
