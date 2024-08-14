<?php

namespace app\controllers;

use app\models\Book;
use app\models\BorrowBook;
use app\models\InfomationBorrowerBook;
use app\models\InfomationBorrowerBookSearch;
use app\models\User;
use Exception;
use Yii;
use yii\db\Query;
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
        Yii::$app->view->params['controller_group'] = 'borrower-book';
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $searchModel = new InfomationBorrowerBookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->setupdata->pageSize();
        $totalCount = $dataProvider->getTotalCount();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalCount' => $totalCount
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

    // public function actionCreateBorrowBook($id)
    // {
    //     $modelHeader = $this->findModel($id);
    //     $borrowBooks = BorrowBook::find()->where(['information_borrower_book_id' => $modelHeader->id, 'status' => 1])->all();

    //     if (Yii::$app->request->isPost) {
    //         $postData = Yii::$app->request->post('BorrowBook', []);
    //         $transaction = Yii::$app->db->beginTransaction();
    //         try {
    //             $modelData = [];
    //             $currentDateTime = date('Y-m-d H:i:s');
    //             $currentUser = Yii::$app->user->identity->id;

    //             foreach ($postData['information_borrower_book_id'] as $key => $informationBorrowerBookID) {
    //                 $modelData[] = [
    //                     $informationBorrowerBookID,
    //                     $postData['book_id'][$key],
    //                     $postData['code'][$key],
    //                     $postData['quantity'][$key],
    //                     $postData['start'][$key],
    //                     $postData['end'][$key],
    //                     $postData['status'][$key],
    //                     $currentDateTime, 
    //                     $currentUser, 
    //                     $currentDateTime,
    //                     $currentUser
    //                 ];
    //             }

    //             Yii::$app->db->createCommand()->batchInsert(BorrowBook::tableName(), [
    //                 'information_borrower_book_id',
    //                 'book_id',
    //                 'code',
    //                 'quantity',
    //                 'start',
    //                 'end',
    //                 'status',
    //                 'created_at',
    //                 'created_by',
    //                 'updated_at',
    //                 'updated_by'
    //             ], $modelData)->execute();

    //             $transaction->commit();
    //             Yii::$app->session->setFlash('success', 'Borrowed books created successfully.');
    //             return $this->redirect(Yii::$app->request->referrer);
    //         } catch (\Exception $e) {
    //             $transaction->rollBack();
    //             Yii::$app->session->setFlash('error', 'Failed to create borrowed books. ' . $e->getMessage());
    //         }
    //     }
    //     if (Yii::$app->request->post('action') == 'inventoryId') {
    //         $inventoryId = Yii::$app->request->post('inventoryId');


    //         $modelItems = BorrowBook::find()
    //             ->andWhere(['code' => $inventoryId])
    //             ->one();
    //         $status = 0;
    //         if (!empty($modelItems)) {
    //             $status = 1;
    //         }
    //         return json_encode(['status' => $status]);
    //     }


    //     $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    //     return $this->render('_form_borrow_book', [
    //         'borrowBook' => [],
    //         'borrowBooks' => $borrowBooks,
    //         'socialItems' => $socialItems,
    //         'modelHeader' => $modelHeader
    //     ]);
    // }


    public function actionCreateBorrowBook($id)
    {
        $modelHeader = $this->findModel($id);
        $borrowBooks = BorrowBook::find()->where(['information_borrower_book_id' => $modelHeader->id, 'status' => 1])->all();

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('BorrowBook', []);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $borrowBookModel = new BorrowBook();
                $errors = $borrowBookModel->validateBorrowRequests($postData);

                if (!empty($errors)) {
                    throw new \Exception(implode(' ', $errors));
                }

                $currentDateTime = date('Y-m-d H:i:s');
                $modelData = [];

                foreach ($postData['information_borrower_book_id'] as $key => $informationBorrowerBookID) {
                    $bookId = $postData['book_id'][$key];
                    $requestedQuantity = (int)$postData['quantity'][$key];

                    $modelData[] = [
                        $informationBorrowerBookID,
                        $bookId,
                        $postData['code'][$key],
                        $requestedQuantity,
                        $postData['start'][$key],
                        $postData['end'][$key],
                        $postData['status'][$key],
                        $currentDateTime,
                        $currentDateTime
                    ];
                }

                Yii::$app->db->createCommand()->batchInsert(BorrowBook::tableName(), [
                    'information_borrower_book_id',
                    'book_id',
                    'code',
                    'quantity',
                    'start',
                    'end',
                    'status',
                    'created_at',
                    'updated_at'
                ], $modelData)->execute();

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'សៀវភៅដែលបានខ្ចីត្រូវបានបង្កើតដោយជោគជ័យ។');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'បរាជ័យក្នុងការបង្កើតសៀវភៅខ្ចី. ' . $e->getMessage());
            }
        }

        if (Yii::$app->request->post('action') == 'inventoryId') {
            $inventoryId = Yii::$app->request->post('inventoryId');

            $modelItems = BorrowBook::find()
                ->andWhere(['code' => $inventoryId])
                ->one();
            $status = 0;
            if (!empty($modelItems)) {
                $status = 1;
            }
            return json_encode(['status' => $status]);
        }

        $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
        return $this->render('_form_borrow_book', [
            'borrowBook' => [],
            'borrowBooks' => $borrowBooks,
            'socialItems' => $socialItems,
            'modelHeader' => $modelHeader
        ]);
    }

    
    
    public function actionUpdateBorrowBook($id)
    {
        $modelHeader = $this->findModel($id);
        $borrowBooks = BorrowBook::find()->where(['information_borrower_book_id' => $modelHeader->id, 'status' => 1])->all();

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('BorrowBook', []);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($borrowBooks as $key => $borrowBook) {
                    if (isset($postData['information_borrower_book_id'][$key])) {
                        $borrowBook->information_borrower_book_id = $postData['information_borrower_book_id'][$key];
                        $borrowBook->book_id = $postData['book_id'][$key];
                        $borrowBook->code = $postData['code'][$key];
                        $borrowBook->quantity = $postData['quantity'][$key];
                        $borrowBook->start = $postData['start'][$key];
                        $borrowBook->end = $postData['end'][$key];
                        $borrowBook->status = $postData['status'][$key];
                        $borrowBook->missing_books = $postData['missing_books'][$key];

                        if (!$borrowBook->save()) {
                            throw new Exception("Update failed for record ID {$borrowBook->id}: " . json_encode($borrowBook->getErrors()));
                        }
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'ការអាប់ដេតសៀវភៅត្រូវបានរក្សាទុកដោយជោគជ័យ');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'បរាជ័យក្នុងការធ្វើបច្ចុប្បន្នភាពសៀវភៅដែលខ្ចី. ' . $e->getMessage());
            }
        }

        $socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
        return $this->render('_update_borrow_book', [
            'borrowBook' => $borrowBooks,
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
        if (($model = InfomationBorrowerBook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChart()
    {
        // Initialize an array with 0 counts for each month
        $monthlyCounts = array_fill(0, 12, 0);

        // Fetch data from the BorrowBook model, grouped by month
        $data = (new Query())
            ->select(['MONTH(start) AS month', 'COUNT(*) AS count'])
            ->from('borrow_book')
            ->groupBy(['MONTH(start)'])
            ->all();

        // Populate the monthly counts array
        foreach ($data as $item) {
            $monthIndex = $item['month'] - 1; // Convert to 0-based index
            $monthlyCounts[$monthIndex] = (int)$item['count'];
        }

        // Labels for the 12 months
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return $this->render('chart', [
            'labels' => $labels,
            'counts' => $monthlyCounts,
        ]);
    }
}
