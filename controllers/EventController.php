<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class EventController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
                Yii::$app->session->setFlash('eventCreated', 'Event has been created successfully.');
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'errors' => $model->errors];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('eventCreated', 'Event has been created successfully.');
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
                Yii::$app->session->setFlash('eventUpdated', 'Event has been updated successfully.');
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'errors' => $model->errors];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('eventUpdated', 'Event has been updated successfully.');
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
