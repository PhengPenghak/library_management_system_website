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

                if (!$model->save()) throw new Exception("បរាជ័យក្នុងការរក្សាទុក! លេខកូដ 001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ");
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

                if (!$model->save()) throw new Exception("បរាជ័យក្នុងការរក្សាទុក! លេខកូដ 001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ");

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
                $bookUpdates = [];
                $errors = []; // To store errors

                // Step 1: Prepare data and check available quantities
                foreach ($postData['information_distribution_by_grade_id'] as $key => $informationBorrowerBookID) {
                    $bookId = $postData['book_id'][$key];
                    $quantity = $postData['quantity'][$key];

                    // Check the available quantity for the book
                    $book = Book::findOne($bookId);
                    if (!$book) {
                        $errors[] = "Book with ID {$bookId} not found.";
                        continue; // Skip this iteration if the book is not found
                    }

                    if ($quantity > $book->quantity) {
                        $errors[] = "សំណើរចំនួន {$quantity} ចំនួនសរុបមានត្រឹមតែ {$book->quantity}.";
                        continue; // Skip this iteration if the quantity exceeds available stock
                    }

                    // Prepare data for batch insert
                    $modelData[] = [
                        $informationBorrowerBookID,
                        $bookId,
                        $quantity,
                        $postData['start'][$key],
                        $postData['end'][$key],
                        $postData['status'][$key],
                    ];

                    // Prepare data for updating book quantities
                    if (isset($bookUpdates[$bookId])) {
                        $bookUpdates[$bookId] += $quantity; // Aggregate quantities for the same book
                    } else {
                        $bookUpdates[$bookId] = $quantity;
                    }
                }

                // Step 2: Check if there are any errors before proceeding
                if (!empty($errors)) {
                    // Handle errors (e.g., log them and return a response)
                    Yii::$app->session->setFlash('error', implode('<br>', $errors));
                    return $this->redirect(Yii::$app->request->referrer); // Redirect back with error messages
                }

                // Step 3: Perform batch insert if no errors
                if (!empty($modelData)) {
                    Yii::$app->db->createCommand()->batchInsert(BookDistributionByGrade::tableName(), [
                        'information_distribution_by_grade_id',
                        'book_id',
                        'quantity',
                        'start',
                        'end',
                        'status'
                    ], $modelData)->execute();
                }

                // Step 4: Update book quantities
                foreach ($bookUpdates as $bookId => $totalQuantity) {
                    Yii::$app->db->createCommand()->update('book', [
                        'quantity' => new \yii\db\Expression('quantity - :quantity', [':quantity' => $totalQuantity])
                    ], ['id' => $bookId])->execute();
                }


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
            Yii::debug($postData, 'postData');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $updateQuantities = []; // Prepare to collect quantities to update

                foreach ($BookDistributionByGrades as $key => $borrowBook) {
                    if (isset($postData[$key])) {
                        $borrowBook->attributes = $postData[$key];


                        $quantityToAdd = $borrowBook->quantity;
                        $bookId = $borrowBook->book_id;

                        // Update the book quantity
                        $book = Book::findOne($bookId);

                        if ($book) {
                            // echo "<pre>";
                            // print_r($book);
                            // exit;
                            $book->quantity += $quantityToAdd; // Increase quantity of the book
                            if (!$book->save()) {
                                Yii::error($book->getErrors(), 'bookErrors'); // Log errors
                                throw new Exception("Failed to update book ID {$bookId}: " . json_encode($book->getErrors()));
                            }
                        } else {
                            throw new Exception("Book not found for ID {$bookId}");
                        }


                        // Save the borrow book record
                        if (!$borrowBook->save()) {
                            Yii::error($borrowBook->getErrors(), 'borrowBookErrors'); // Log errors
                            throw new Exception("Update failed for record ID {$borrowBook->id}: " . json_encode($borrowBook->getErrors()));
                        }
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'ការអាប់ដេតត្រូវបានរក្សាទុកដោយជោគជ័យ');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'បរាជ័យក្នុងការធ្វើបច្ចុប្បន្នភាពសៀវភៅដែលខ្ចី. ' . $e->getMessage());
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
