<?php

namespace app\controllers;

use app\models\BorrowBook;
use app\models\BorrowBookSearch;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\InfomationBorrowerBookSearch;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
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

    /**
     * Lists all Blog models.
     * @return mixed
     */


    public function actionBorrowerBook()
    {
        $gradeSearchModel = new GradeSearch();
        $gradeDataProvider = $gradeSearchModel->search(Yii::$app->request->queryParams);
        $grades = Grade::find()->all();
        $gradeList = ArrayHelper::map($grades, 'id', 'title');
        $searchModel = new InfomationBorrowerBookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($dataProvider->getCount() === 0) {
            throw new NotFoundHttpException('No records found.');
        }

        return $this->render('borrower-book/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gradeSearchModel' => $gradeSearchModel,
            'gradeDataProvider' => $gradeDataProvider,
            'gradeList' => $gradeList,
        ]);
    }

    public function actionDetails($id)
    {
        $searchModel = new BorrowBookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['grade_id' => $id]);

        return $this->render('borrower-book/details', [
            'id' => $id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreatePdf($id)
    {
        $reportBorrowerBook = Yii::$app->db->createCommand("SELECT
        borrow_book.id AS ID,
        borrow_book.code,
        borrow_book.quantity,
        borrow_book.start,
        borrow_book.end,
        infomation_borrower_book.username,
        infomation_borrower_book.gender,
        grade.title AS grade_title,
        book.title AS bookTitle
    FROM
        borrow_book
        INNER JOIN infomation_borrower_book ON infomation_borrower_book.id = borrow_book.information_borrower_book_id
        INNER JOIN grade ON grade.id = infomation_borrower_book.grade_id
        INNER JOIN book ON book.id = borrow_book.book_id
    WHERE
        infomation_borrower_book.grade_id = :gradeId
")
            ->bindParam('gradeId', $id)
            ->queryAll();


        $mpdf = new Mpdf([
            'orientation' => 'L',
            'format' => 'A4',
            'default_font' => 'khmerOS',
            'fontDir' => array_merge((new ConfigVariables())->getDefaults()['fontDir'], [
                Yii::getAlias('@webroot') . '/fonts',
            ]),
            'fontdata' => array_merge((new FontVariables())->getDefaults()['fontdata'], [
                'khmerOS' => [
                    'R' => 'khmerOS.ttf',
                    'B' => 'khmerOS.ttf',
                ],
            ]),
        ]);

        $html = $this->renderPartial('borrower-book/pdf-template', [
            'reportBorrowerBook' => $reportBorrowerBook,
        ]);

        $mpdf->WriteHTML($html);

        $mpdf->Output('របាយការណ៏អ្នកខ្ចីសៀបភៅ.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function actionExportExcel($id)
    {
        $reportBorrowerBook = Yii::$app->db->createCommand("SELECT
                borrow_book.id AS ID, borrow_book.code, borrow_book.quantity, borrow_book.start, borrow_book.end,
                infomation_borrower_book.username, infomation_borrower_book.gender,
                grade.title,
                book.title AS bookTitle
            FROM
                borrow_book
                INNER JOIN infomation_borrower_book ON infomation_borrower_book.id = borrow_book.information_borrower_book_id
                INNER JOIN grade ON grade.id = infomation_borrower_book.grade_id
                INNER JOIN book ON book.id = borrow_book.book_id
            WHERE
                grade_id = :gradeId
        ")
            ->bindParam('gradeId', $id)
            ->queryAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $header = [
            'លេខរៀង',
            'ឈ្មោះសិស្ស',
            'ភេទ',
            'ថ្នាក់',
            'ចំណងជើងរឿង',
            'លេខសារពើភ័ណ្ខ',
            'ចំនួនសៀវភៅ',
            'ថ្ងៃ​ចាប់ផ្តើមកាលបរិច្ឆេទ',
            'កាលបរិច្ឆេទបញ្ចប់',
        ];
        $sheet->fromArray([$header], NULL, 'A1');
        $dataRows = [];
        foreach ($reportBorrowerBook as $borrowerBook) {
            $dataRows[] = [
                $borrowerBook['ID'],
                $borrowerBook['username'],
                $borrowerBook['gender'],
                $borrowerBook['title'],
                $borrowerBook['bookTitle'],
                $borrowerBook['code'],
                $borrowerBook['quantity'],
                $borrowerBook['start'],
                $borrowerBook['end'],
            ];
        }
        $sheet->fromArray($dataRows, NULL, 'A2');
        $writer = new Xlsx($spreadsheet);
        $filename = 'របាយការណ៏អ្នកខ្ចីសៀបភៅ.xlsx';
        $writer->save($filename);
        Yii::$app->response->sendFile($filename, $filename, [
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'inline' => false,
        ])->send();
        unlink($filename);
    }
}
