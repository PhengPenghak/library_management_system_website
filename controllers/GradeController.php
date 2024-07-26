<?php

namespace app\controllers;

use app\models\Grade;
use app\models\GradeSearch;
use app\models\User;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GradeController implements the CRUD actions for RoomType model.
 */
class GradeController extends Controller
{
    /**
     * @inheritDoc
     */
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
        Yii::$app->view->params['controller_group'] = 'grade';
        if (in_array($action->id, ['view'])) {
            $this->layout = '_profile_detail';
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all RoomType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GradeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->setupdata->pageSize();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new Grade();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction_exception = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) throw new Exception("Failed to Save! Code #001");


                    $transaction_exception->commit();
                    Yii::$app->session->setFlash('success', "Record has been created successfully");
                    return $this->redirect(['index']);
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('warning', $ex->getMessage());
                    $transaction_exception->rollBack();
                }

                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction_exception = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) throw new Exception("Failed to Save! Code #001");

                    $transaction_exception->commit();
                    Yii::$app->session->setFlash('success', "Record has been updated successfully");
                    return $this->redirect(['index']);
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('warning', $ex->getMessage());
                    $transaction_exception->rollBack();
                }

                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RoomType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $transaction_exception = Yii::$app->db->beginTransaction();

        try {
            if (!$model->delete()) throw new Exception("Failed to delete this record!");

            $transaction_exception->commit();
            Yii::$app->session->setFlash('success', "Record deleted successful");
            return $this->redirect(Yii::$app->request->referrer);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('warning', $ex->getMessage());
            $transaction_exception->rollBack();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Finds the RoomType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RoomType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
