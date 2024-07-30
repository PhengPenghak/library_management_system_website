<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookSearch;
use app\models\CategoryBook;
use app\models\User;
use Yii;
use Exception;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class BookController extends Controller
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

    /**
     * Lists all Blog models.
     * @return mixed
     */

    public function beforeAction($action)
    {
        Yii::$app->view->params['controller_group'] = 'book';
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->setupdata->pageSize();
        $totalCount = $dataProvider->getTotalCount();
        $categories = CategoryBook::find()->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalCount' => $totalCount,
            'categories' => $categories,

        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $transaction_exception = Yii::$app->db->beginTransaction();

            try {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (!empty($model->imageFile) && $model->upload()) $model->imageFile = null;

                if (!$model->save()) throw new Exception("Failed to Save! Code #001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "Book saved successfully");

                return $this->redirect(['index']);
            } catch (Exception $ex) {
                echo "<pre>";
                print_r($ex->getMessage());
                echo "</pre>";
                exit;
                Yii::$app->session->setFlash('warning', $ex->getMessage());
                $transaction_exception->rollBack();
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($this->request->isPost && $model->load($this->request->post())) {

            $transaction_exception = Yii::$app->db->beginTransaction();

            try {
                $oldImageUrl = $model->img_url;
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (!empty($model->imageFile) && $model->upload()) {
                    if (!empty($oldImageUrl) && file_exists(Yii::$app->basePath . '/web/' . $oldImageUrl)) {
                        unlink(Yii::$app->basePath . '/web/' . $oldImageUrl);
                    }
                    $model->imageFile = null;
                }

                if (!$model->save()) throw new Exception("Failed to Save! Code #001");

                $transaction_exception->commit();
                Yii::$app->session->setFlash('success', "Post saved successfully");
                return $this->redirect(['index']);
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('warning', $ex->getMessage());
                $transaction_exception->rollBack();
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Item deleted successfully");
        return $this->redirect(Yii::$app->request->referrer);
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
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    // public function actionExportExcel()
    // {
    //     $books = Book::find()->all();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Set document properties
    //     $spreadsheet->getProperties()->setCreator('Your Name')
    //         ->setLastModifiedBy('Your Name')
    //         ->setTitle('Books List')
    //         ->setSubject('Books List')
    //         ->setDescription('List of books exported to Excel.')
    //         ->setKeywords('books excel')
    //         ->setCategory('Export');

    //     // Add header row
    //     $sheet->setCellValue('A1', 'ID')
    //         ->setCellValue('B1', 'Title')
    //         ->setCellValue('C1', 'Author')
    //         ->setCellValue('D1', 'Published Date');

    //     // Add data rows
    //     $row = 2;
    //     foreach ($books as $book) {
    //         $sheet->setCellValue('A' . $row, $book->id)
    //             ->setCellValue('B' . $row, $book->title);

    //         $row++;
    //     }

    //     // Rename worksheet
    //     $sheet->setTitle('Books');

    //     // Set active sheet index to the first sheet
    //     $spreadsheet->setActiveSheetIndex(0);

    //     // Redirect output to a client’s web browser (Xlsx)
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="books.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     Yii::$app->end();
    // }

    // public function actionExportPdf()
    // {
    //     // Fetch data
    //     $books = Book::find()->all();

    //     // Initialize mPDF
    //     $mpdf = new Mpdf([
    //         'default_font' => 'KhmerOS'
    //     ]);

    //     // Add custom font configuration
    //     $mpdf->AddFontDirectory('@webroot/fonts');
    //     $mpdf->AddFont('KhmerOS', '', 'KhmerOS.ttf', true);
    //     $html = $this->renderPartial('pdf-template', ['books' => $books]);

    //     $mpdf->WriteHTML($html);

    //     $mpdf->Output('Books.pdf', 'D');
    // }
}
