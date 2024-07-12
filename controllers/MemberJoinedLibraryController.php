<?php

namespace app\controllers;

use app\models\MemberJoinedLibrary;
use app\models\MemberJoinedLibrarySearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberJoinedLibraryController implements the CRUD actions for MemberJoinedLibrary model.
 */
class MemberJoinedLibraryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MemberJoinedLibrary models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MemberJoinedLibrarySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberJoinedLibrary model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MemberJoinedLibrary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionForm($id = '')
    {
        $model = !empty($id) ? MemberJoinedLibrary::findOne($id) : new MemberJoinedLibrary();
        $master = Yii::$app->master;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction_exception = Yii::$app->db->beginTransaction();
                try {
                    // print_r($model->grade_id);
                    // exit;
                    if (!$model->save()) throw new Exception($master->errToString($model->getErrors()));

                    $transaction_exception->commit();
                    Yii::$app->session->setFlash('success', "Record has been created successfully");
                    return $this->redirect(Yii::$app->request->referrer);
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('warning', $ex->getMessage());
                    $transaction_exception->rollBack();
                }

                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MemberJoinedLibrary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MemberJoinedLibrary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MemberJoinedLibrary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberJoinedLibrary::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
