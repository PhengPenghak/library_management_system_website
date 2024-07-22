<?php

namespace app\controllers;

use app\components\Formater;
use app\models\BorrowBookSearch;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\InfomationBorrowerBookSearch;
use app\models\MemberJoinedLibrary;
use app\models\MemberJoinedLibrarySearch;
use DateTime;
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
        $searchModel->load(Yii::$app->request->queryParams);


        try {
            $sql = "SELECT
            borrow_book.id AS ID,
            borrow_book.`code`,
            borrow_book.quantity,
            borrow_book.`start`,
            borrow_book.`end`,
            infomation_borrower_book.username,
            infomation_borrower_book.gender,
            grade.title AS grade_title,
            book.title AS book_title
        FROM
            borrow_book
            INNER JOIN infomation_borrower_book ON infomation_borrower_book.id = borrow_book.information_borrower_book_id
            INNER JOIN grade ON grade.id = infomation_borrower_book.grade_id
            INNER JOIN book ON book.id = borrow_book.book_id
        WHERE
            grade.id = :gradeId";

            // Count SQL query
            $countSql = "SELECT COUNT(*) 
            FROM borrow_book
            INNER JOIN infomation_borrower_book ON infomation_borrower_book.id = borrow_book.information_borrower_book_id
            INNER JOIN grade ON grade.id = infomation_borrower_book.grade_id
            INNER JOIN book ON book.id = borrow_book.book_id
        WHERE
            grade.id = :gradeId";
            $params = [':gradeId' => $id];
            if (!empty($searchModel->code)) {
                $sql .= " AND borrow_book.code LIKE :code";
                $countSql .= " AND borrow_book.code LIKE :code";
                $params[':code'] = '%' . $searchModel->code . '%';
            }

            if (!empty($searchModel->username)) {
                $sql .= " AND infomation_borrower_book.username LIKE :username";
                $countSql .= " AND infomation_borrower_book.username LIKE :username";
                $params[':username'] = '%' . $searchModel->username . '%';
            }

            // Create SqlDataProvider with combined SQL queries and parameters
            $totalCount = Yii::$app->db->createCommand($countSql, $params)->queryScalar();
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'params' => $params,
                'totalCount' => $totalCount,
                'pagination' => [
                    'pageSize' => 2,
                ],
            ]);

            return $this->render('borrower-book/details', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            Yii::error('Error in actionDetails: ' . $e->getMessage());
            throw $e;
        }
    }


    public function actionCreatePdf($id)
    {
        $reportBorrowerBook = Yii::$app->db->createCommand("
            SELECT
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

        $mpdf = new Mpdf([
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

        $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function actionExportExcel($id)
    {
        // Fetch data from your database or any other source
        $reportBorrowerBook = Yii::$app->db->createCommand("
            SELECT
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

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
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

        // Set header row data
        $sheet->fromArray([$header], NULL, 'A1');

        // Data rows
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

        // Set data rows
        $sheet->fromArray($dataRows, NULL, 'A2');

        // Create Excel Writer object
        $writer = new Xlsx($spreadsheet);

        // Save Excel file to a temporary location
        $filename = 'report.xlsx';
        $writer->save($filename);

        // Set headers to download the Excel file
        Yii::$app->response->sendFile($filename, $filename, [
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'inline' => false,
        ])->send();

        // Delete the temporary file after sending
        unlink($filename);
    }
    public function actionLibrary()
    {
        $selectedDate = empty(Yii::$app->request->get('selectedDate')) ? date("m-Y") : Yii::$app->request->get('selectedDate');
        $gradeSearchModel = new MemberJoinedLibrarySearch();
        $gradeDataProvider = $gradeSearchModel->search(Yii::$app->request->queryParams);
        $grades = Grade::find()->all();
        $gradeList = ArrayHelper::map($grades, 'id', 'title');
        $searchModel = new MemberJoinedLibrarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($dataProvider->getCount() === 0) {
            throw new NotFoundHttpException('No records found.');
        }
        $scheduleType = Yii::$app->request->getQueryParam('scheduleType', 0);

        $activityProvider = new ActiveDataProvider([
            'query' => MemberJoinedLibrarySearch::find()
                ->andWhere(['like', 'DATE(dateTime)', $selectedDate])
                ->andWhere(['status' => $scheduleType]),
            // 'pagination' => [
            //     'pageSize' => Yii::$app->params['pageSize']
            // ],
            'sort' => [
                'defaultOrder' => [
                    'dateTime' => SORT_DESC, // Replace 'id' with the column you want to sort by
                ]
            ],
        ]);


        return $this->render('library/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gradeSearchModel' => $gradeSearchModel,
            'gradeDataProvider' => $gradeDataProvider,
            'selectedDate' => $selectedDate,
            'activityProvider' => $activityProvider,

            'gradeList' => $gradeList

        ]);
    }
    public function actionReportLibrary()
    {
        Yii::$app->cache->flush();

        // Ensure no output is sent before the PDF generation
        if (ob_get_contents()) ob_end_clean();
        $dateFromUrl = Yii::$app->request->get('selectMonth');
        if (empty($dateFromUrl)) {
            $dateFromUrl = date("Y-m-d");
        }
        $date = new DateTime($dateFromUrl);
        $daysInMonth = $date->format('t');
        $libraryItems = MemberJoinedLibrary::find()
            ->andWhere(['between', 'created_at', $date->format('Y-m-01'), $date->format('Y-m-t')])
            ->all();
        // echo "<pre>";
        // print_r($libraryItems);
        // exit;

        $mpdf = new Mpdf([
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
        $html = $this->renderPartial('library/report_library', [
            'daysInMonth' => $daysInMonth,
            'libraryItems' => $libraryItems,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE);
    }
}
