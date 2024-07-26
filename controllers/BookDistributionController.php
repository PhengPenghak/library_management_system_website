<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookDistributionByGrade;
use app\models\InfomationBookDistributionByGrade;
use app\models\InfomationBookDistributionByGradeSearch;
use app\models\User;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BookDistributionController extends \yii\web\Controller
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
        Yii::$app->view->params['controller_group'] = 'book-distribution';
        Yii::$app->view->params['controller_group'] = 'borrower-book';

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $searchModel = new InfomationBookDistributionByGradeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->setupdata->pageSize();
        $totalCount = $dataProvider->getTotalCount();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalCount' => $totalCount
        ]);
    }

    public function actionCreateInformationBookDistribution()
    {
        $model = new InfomationBookDistributionByGradeSearch();
        if ($this->request->isPost && $model->load($this->request->post())) {

            $transaction_exception = Yii::$app->db->beginTransaction();

            try {

                if (!$model->save()) throw new Exception("Failed to Save! Code #001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "Data saved successfully");
                return $this->redirect(['detail', 'id' => $model->id]);
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', $ex->getMessage());

                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                exit;
                $transaction_exception->rollBack();
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('_form_information_book-distribution', [
            'model' => $model,
        ]);
    }

    public function actionDetail($id)
    {
        $modelHeader = $this->findModel($id);
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            $transaction_exception = Yii::$app->db->beginTransaction();

            try {

                if (!$model->save()) throw new Exception("Failed to Save! Code #001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "Data saved successfully");

                return $this->redirect(['detail', 'id' => $model->id]);
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', $ex->getMessage());
                $transaction_exception->rollBack();
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('_form_information_book-distribution', [
            'model' => $model,
            'modelHeader' => $modelHeader,
        ]);
    }

    public function actionCreateBookDistribution($id)
    {
        $modelHeader = $this->findModel($id);
        $BookDistributionByGrades = BookDistributionByGrade::find()->where(['information_distribution_by_grade_id' => $modelHeader->id, 'status' => 1])->all();

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('BookDistributionByGrade', []);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelData = [];
                foreach ($postData['information_distribution_by_grade_id'] as $key => $informationBorrowerBookID) {
                    $modelData[] = [
                        $informationBorrowerBookID,
                        $postData['book_id'][$key],
                        $postData['quantity'][$key],
                        $postData['start'][$key],
                        $postData['end'][$key],
                        $postData['status'][$key],
                    ];
                }

                Yii::$app->db->createCommand()->batchInsert(BookDistributionByGrade::tableName(), [
                    'information_distribution_by_grade_id',
                    'book_id',
                    'quantity',
                    'start',
                    'end',
                    'status'
                ], $modelData)->execute();

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Borrowed books created successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Failed to create borrowed books. ' . $e->getMessage());
            }
        }

        $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
        return $this->render('_form_book-distribution', [
            'borrowBook' => [],
            'BookDistributionByGrades' => $BookDistributionByGrades,
            'socialItems' => $socialItems,
            'modelHeader' => $modelHeader
        ]);
    }

    public function actionUpdateBookDistribution($id)
    {
        $modelHeader = $this->findModel($id);
        $BookDistributionByGrades = BookDistributionByGrade::find()->where(['information_distribution_by_grade_id' => $modelHeader->id, 'status' => 1])->all();

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('BookDistributionByGrade', []);
            Yii::debug($postData, 'postData'); // Debugging post data

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($BookDistributionByGrades as $key => $borrowBook) {
                    if (isset($postData[$key])) {
                        $borrowBook->attributes = $postData[$key];
                        if (!$borrowBook->save()) {
                            Yii::error($borrowBook->getErrors(), 'borrowBookErrors'); // Log errors
                            throw new Exception("Update failed for record ID {$borrowBook->id}: " . json_encode($borrowBook->getErrors()));
                        }
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Borrowed books updated successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Failed to update borrowed books. ' . $e->getMessage());
            }
        }

        $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
        return $this->render('_update_book-distribution', [
            'BookDistributionByGrades' => $BookDistributionByGrades,
            'socialItems' => $socialItems,
            'modelHeader' => $modelHeader
        ]);
    }




    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfomationBookDistributionByGrade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
