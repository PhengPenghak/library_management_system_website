<?php

namespace app\controllers;

use app\models\BorrowBookSearch;
use app\models\Grade;
use app\models\GradeSearch;
use app\models\InfomationBorrowerBookSearch;
use app\models\MemberJoinedLibrary;
use app\models\MemberJoinedLibrarySearch;
use app\models\User;
use DateTime;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
                // 'access' => [
                //     'class' => \yii\filters\AccessControl::class,
                //     'rules' => [
                //         [
                //             'actions' => User::getUserPermission(Yii::$app->controller->id),
                //             'allow' => true,
                //         ]
                //     ],
                // ],
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
        Yii::$app->view->params['controller_group'] = 'report';
        return parent::beforeAction($action);
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
        // if ($dataProvider->getCount() === 0) {
        //     throw new NotFoundHttpException('No records found.');
        // }

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

        // Add title
        $title = 'របាយការណ៏អ្នកខ្ចីសៀវភៅ';
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:I1');

        // Apply title styles
        $titleStyleArray = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'name' => 'KhmerOS',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1')->applyFromArray($titleStyleArray);
        $sheet->getRowDimension('1')->setRowHeight(40);

        // Headers
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
        $sheet->fromArray([$header], NULL, 'A2');

        // Apply header styles
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFFD700', // Gold color
                ],
            ],
        ];
        $sheet->getStyle('A2:I2')->applyFromArray($headerStyleArray);
        $sheet->getRowDimension('2')->setRowHeight(30);

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
        $sheet->fromArray($dataRows, NULL, 'A3');

        // Apply data rows styles
        $dataStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A3:I' . (count($dataRows) + 2))->applyFromArray($dataStyleArray);

        // Auto size columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'របាយការណ៏អ្នកខ្ចីសៀវភៅ.xlsx';
        $writer->save($filename);
        Yii::$app->response->sendFile($filename, $filename, [
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'inline' => false,
        ])->send();
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
