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

    public function actionExportPdfBorrowBook($id)
    {
        $params = Yii::$app->request->queryParams;
        $from_date = isset($params['BorrowBookSearch']['from_date']) ? $params['BorrowBookSearch']['from_date'] : null;
        $to_date = isset($params['BorrowBookSearch']['to_date']) ? $params['BorrowBookSearch']['to_date'] : null;

        $query = "SELECT
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
        ";

        if ($from_date && $to_date) {
            $query .= " AND DATE(borrow_book.created_at) BETWEEN :from_date AND :to_date";
        }

        $command = Yii::$app->db->createCommand($query);
        $command->bindParam(':gradeId', $id);

        if ($from_date && $to_date) {
            $command->bindValue(':from_date', $from_date);
            $command->bindValue(':to_date', $to_date);
        }

        $reportBorrowerBook = $command->queryAll();

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

    public function actionExportExcelBorrowBook($id)
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
        $title = 'របាយការណ៏អ្នកខ្ចីសៀវភៅ';
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:I1');
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
        $searchModel = new MemberJoinedLibrarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $grades = Grade::find()->all();
        $gradeList = ArrayHelper::map($grades, 'id', 'title');

        return $this->render('member-joind-library/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gradeList' => $gradeList
        ]);
    }



    public function actionExportPdfMemberJoinedLibrary()
    {
        $fromDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['from_date'] ?? null;
        $toDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['to_date'] ?? null;

        if ($fromDate && $toDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $toDate = date('Y-m-d', strtotime($toDate));
        } else {
            throw new \yii\web\BadRequestHttpException('Invalid date parameters.');
        }

        $reportBorrowerBook = Yii::$app->db->createCommand("SELECT member_joined_library.type_joined AS typeJoined,
                CASE 
                    WHEN grade.title LIKE 'ថ្នាក់ទី 1%' THEN 'ថ្នាក់ទី 1'
                    WHEN grade.title LIKE 'ថ្នាក់ទី 2%' THEN 'ថ្នាក់ទី 2'
                    WHEN grade.title LIKE 'ថ្នាក់ទី 3%' THEN 'ថ្នាក់ទី 3'
                    WHEN grade.title LIKE 'ថ្នាក់ទី 4%' THEN 'ថ្នាក់ទី 4'
                    WHEN grade.title LIKE 'ថ្នាក់ទី 5%' THEN 'ថ្នាក់ទី 5'
                    WHEN grade.title LIKE 'ថ្នាក់ទី 6%' THEN 'ថ្នាក់ទី 6'
                    ELSE grade.title 
                END AS gradeName,
                DATE_FORMAT(member_joined_library.dateTime, '%d') AS day,
                SUM(member_joined_library.total_member) AS total_member,
                SUM(member_joined_library.total_member_female) AS total_member_female
            FROM member_joined_library
            LEFT JOIN grade ON grade.id = member_joined_library.grade_id
            WHERE member_joined_library.dateTime BETWEEN :fromDate AND :toDate
            GROUP BY day, member_joined_library.type_joined, gradeName
            ORDER BY day, member_joined_library.type_joined
        ")
            ->bindValue(':fromDate', $fromDate)
            ->bindValue(':toDate', $toDate)
            ->queryAll();

        $totalMembersAllDays = 0;
        $totalMembersFemaleAllDays = 0;
        $gradeNames = ["មត្តេយ្យ", "ថ្នាក់ទី 1", "ថ្នាក់ទី 2", "ថ្នាក់ទី 3", "ថ្នាក់ទី 4", "ថ្នាក់ទី 5", "ថ្នាក់ទី 6", "គ្រូ", "សហគមន៏",];
        $gradeTotals = array_fill_keys($gradeNames, ['total_member' => 0, 'total_member_female' => 0]);

        $formattedData = [];
        foreach ($reportBorrowerBook as $entry) {
            $day = intval($entry['day']);
            if (!isset($formattedData[$day])) {
                $formattedData[$day] = [];
            }
            $formattedData[$day][] = $entry;
        }


        // Initialize mPDF
        $config = new \Mpdf\Config\ConfigVariables();
        $fontDirs = $config->getDefaults()['fontDir'];
        $fontData = (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'];
        $mpdf = new Mpdf([
            'format' => 'A4',
            'default_font' => 'khmerOS',
            'fontDir' => array_merge($fontDirs, [
                Yii::getAlias('@webroot') . '/fonts',
            ]),
            'fontdata' => array_merge($fontData, [
                'khmerOS' => [
                    'R' => 'khmerOS.ttf',
                    'B' => 'khmerOS.ttf',
                ],
            ]),
        ]);
        $html = $this->renderPartial('member-joind-library/_pdf_template', [

            'formattedData' => $formattedData,
            'gradeNames' => $gradeNames,
            'gradeTotals' => $gradeTotals,
            'totalMembersAllDays' => $totalMembersAllDays,
            'totalMembersFemaleAllDays' => $totalMembersFemaleAllDays,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function actionExportExcelMemberJoinedLibrarys()
    {
        $fromDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['from_date'] ?? null;
        $toDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['to_date'] ?? null;
        $typeJoined = Yii::$app->request->get('MemberJoinedLibrarySearch')['type_joined'] ?? 'default_type_joined';


        if ($fromDate && $toDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $toDate = date('Y-m-d', strtotime($toDate));
        } else {
            throw new \yii\web\BadRequestHttpException('Invalid date parameters.');
        }

        $reportBorrowerBook = Yii::$app->db->createCommand("SELECT member_joined_library.type_joined AS typeJoined,
        CASE 
            WHEN grade.title LIKE 'ថ្នាក់ទី 1%' THEN 'ថ្នាក់ទី 1'
            WHEN grade.title LIKE 'ថ្នាក់ទី 2%' THEN 'ថ្នាក់ទី 2'
            WHEN grade.title LIKE 'ថ្នាក់ទី 3%' THEN 'ថ្នាក់ទី 3'
            WHEN grade.title LIKE 'ថ្នាក់ទី 4%' THEN 'ថ្នាក់ទី 4'
            WHEN grade.title LIKE 'ថ្នាក់ទី 5%' THEN 'ថ្នាក់ទី 5'
            WHEN grade.title LIKE 'ថ្នាក់ទី 6%' THEN 'ថ្នាក់ទី 6'
            ELSE grade.title 
        END AS gradeName,
        DATE_FORMAT(member_joined_library.dateTime, '%d') AS day,
        SUM(member_joined_library.total_member) AS total_member,
        SUM(member_joined_library.total_member_female) AS total_member_female
        FROM member_joined_library
        LEFT JOIN grade ON grade.id = member_joined_library.grade_id
        WHERE member_joined_library.dateTime BETWEEN :fromDate AND :toDate
        GROUP BY day, member_joined_library.type_joined, gradeName
        ORDER BY day, member_joined_library.type_joined
        ")
            ->bindValue(':fromDate', $fromDate)
            ->bindValue(':toDate', $toDate)
            ->queryAll();

        $totalMembersAllDays = 0;
        $totalMembersFemaleAllDays = 0;
        $gradeNames = ["មត្តេយ្យ", "ថ្នាក់ទី 1", "ថ្នាក់ទី 2", "ថ្នាក់ទី 3", "ថ្នាក់ទី 4", "ថ្នាក់ទី 5", "ថ្នាក់ទី 6", "គ្រូ", "សហគមន៏",];
        $gradeTotals = array_fill_keys($gradeNames, ['total_member' => 0, 'total_member_female' => 0]);

        $formattedData = [];
        foreach ($reportBorrowerBook as $entry) {
            $day = intval($entry['day']);
            if (!isset($formattedData[$day])) {
                $formattedData[$day] = [];
            }
            $formattedData[$day][] = $entry;
        }


        $file_name = 'hak';
        return $this->renderPartial('member-joind-library/_excel_template', [
            'formattedData' => $formattedData,
            'gradeNames' => $gradeNames,
            'gradeTotals' => $gradeTotals,
            'totalMembersAllDays' => $totalMembersAllDays,
            'totalMembersFemaleAllDays' => $totalMembersFemaleAllDays,
            'file_name' => $file_name
        ]);
    }
}
