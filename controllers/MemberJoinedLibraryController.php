<?php

namespace app\controllers;

use app\models\MemberJoinedLibrary;
use app\models\MemberJoinedLibrarySearch;
use app\models\User;
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
        Yii::$app->view->params['controller_group'] = 'member-joined-library';
        return parent::beforeAction($action);
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
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction_exception = Yii::$app->db->beginTransaction();
                try {

                    if (!$model->save()) throw new Exception("បរាជ័យក្នុងការរក្សាទុក! លេខកូដ 001");

                    $transaction_exception->commit();
                    Yii::$app->session->setFlash('success', "កត់ត្រាអ្នកចូលត្រូវបានបង្កើតដោយជោគជ័យ");
                    return $this->redirect(Yii::$app->request->referrer);
                } catch (Exception $ex) {
                    echo "<pre>";
                    print_r($ex->getMessage());
                    exit;
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
