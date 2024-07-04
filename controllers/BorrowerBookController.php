<?php

namespace app\controllers;

use app\models\Book;
use app\models\BorrowBook;
use app\models\InfomationBorrowerBook;
use app\models\InfomationBorrowerBookSearch;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BorrowerBookController extends \yii\web\Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {

        $searchModel = new InfomationBorrowerBookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->setupdata->pageSize();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateInformationBorrowerBook()
    {
        $model = new InfomationBorrowerBook();
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

        return $this->render('_form_information_borrower_book', [
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

        return $this->render('_form_information_borrower_book', [
            'model' => $model,
            'modelHeader' => $modelHeader,
        ]);
    }

    public function actionBorrowBook($id)
    {
        $modelHeader = $this->findModel($id);

        $borrowBook = BorrowBook::find(['information_borrower_book_id' => $id])->asArray()->all();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('BorrowBook', []);
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $modelData = [];
                foreach ($postData['information_borrower_book_id'] as $key => $time) {
                    $InformationBorrowerBookID = $postData['information_borrower_book_id'][$key];
                    $BookID = $postData['book_id'][$key];
                    $Code = $postData['code'][$key];
                    $Quantity = $postData['quantity'][$key];
                    $Start = $postData['start'][$key];
                    $End = $postData['end'][$key];
                    $Status = $postData['status'][$key];
                    $modelData[] = [$InformationBorrowerBookID, $BookID, $Code, $Quantity, $Start, $End, $Status];
                }

                Yii::$app->db->createCommand()->batchInsert(BorrowBook::tableName(), [
                    'information_borrower_book_id',
                    'book_id',
                    'code',
                    'quantity',
                    'start',
                    'end',
                    'status'
                ], $modelData)->execute();

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Bulk data saved successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Failed to save bulk data. ' . $e->getMessage());
            }
        }

        $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
        return $this->render('_form_borrow_book', [
            'borrowBook' => $borrowBook,
            'socialItems' => $socialItems,
            'modelHeader' => $modelHeader
        ]);
    }





    // private function transformPostData($postData)
    // {
    //     $result = [];
    //     $keys = array_keys($postData);

    //     for ($i = 0; $i < count($postData[$keys[0]]); $i++) {
    //         $item = [];
    //         foreach ($keys as $key) {
    //             $item[$key] = $postData[$key][$i];
    //         }
    //         $result[] = $item;
    //     }

    //     return $result;
    // }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfomationBorrowerBook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
