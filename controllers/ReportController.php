<?php

namespace app\controllers;

use app\components\Formater;
use app\models\BorrowBook;
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
        $selectedDate = Yii::$app->request->get('selectedDate');
        $gradeSearchModel = new MemberJoinedLibrarySearch();
        $gradeDataProvider = $gradeSearchModel->search(Yii::$app->request->queryParams);
        $grades = Grade::find()->all();
        $gradeList = ArrayHelper::map($grades, 'id', 'title');
        $searchModel = new MemberJoinedLibrarySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $scheduleType = Yii::$app->request->getQueryParam('scheduleType', 0);

        !empty($selectedDate) ? $activityProvider = new ActiveDataProvider([
            'query' => MemberJoinedLibrarySearch::find()
                ->andWhere(['like', 'DATE(dateTime)', $selectedDate])
                ->andWhere(['status' => $scheduleType]),

            'sort' => [
                'defaultOrder' => [
                    'dateTime' => SORT_DESC,
                ]
            ],
        ]) : $activityProvider = $dataProvider;

        return $this->render('member-joind-library/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gradeSearchModel' => $gradeSearchModel,
            'gradeDataProvider' => $gradeDataProvider,
            'selectedDate' => $selectedDate,
            'activityProvider' => $activityProvider,

            'gradeList' => $gradeList

        ]);
    }
    public function actionExportPdfMemberJoinedLibrary()
    {
        Yii::$app->cache->flush();

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
        $html = $this->renderPartial('member-joind-library/pdf-template', [
            'daysInMonth' => $daysInMonth,
            'libraryItems' => $libraryItems,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function actionExportExcelMemberJoinedLibrary($id)
    {
        $reportBorrowerBook = Yii::$app->db->createCommand("SELECT 
            member_joined_library.grade_id AS gradeID, 
            member_joined_library.type_joined,
            member_joined_library.total_member, 
            member_joined_library.total_member_female,
            member_joined_library.dateTime,
            grade.title AS gradeName
        FROM member_joined_library
        INNER JOIN grade ON grade.id = member_joined_library.grade_id
        WHERE member_joined_library.grade_id = :gradeId
        ")
            ->bindValue(':gradeId', $id)
            ->queryAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $title = 'របាយការណ៏អ្នកចូលបណ្ណាល័យ';
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

        // Define the header
        $header = [
            'លេខរៀង',
            'មត្តេយ្យ',
            'ថ្នាក់ទី១',
            'ថ្នាក់ទី២',
            'ថ្នាក់ទី៣',
            'ថ្នាក់ទី៤',
            'ថ្នាក់ទី៥',
            'ថ្នាក់ទី៦',
            'គ្រូ',
            'សហគមន៏',
            'សរុប'
        ];
        $sheet->fromArray([$header], null, 'A2');
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
                    'argb' => 'FFFFD700',
                ],
            ],
        ];
        $sheet->getStyle('A2:I2')->applyFromArray($headerStyleArray);
        $sheet->getRowDimension('2')->setRowHeight(30);
        $dataRows = [];
        foreach ($reportBorrowerBook as $index => $borrowerBook) {
            $dataRows[] = [
                $index + 1,
                $borrowerBook['gradeName'],  // This column might need adjustment based on actual data structure
                $borrowerBook['type_joined'] == 1 ? $borrowerBook['total_member'] : 0,
                $borrowerBook['type_joined'] == 2 ? $borrowerBook['total_member'] : 0,
            ];
        }
        $sheet->fromArray($dataRows, null, 'A3');
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
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'របាយការណ៏អ្នកចូលបណ្ណាល័យ.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return Yii::$app->response->sendFile($tempFile, $filename, [
            'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'inline' => false,
        ])->on(\yii\web\Response::EVENT_AFTER_SEND, function ($event) {
            unlink($event->data);
        }, $tempFile);
    }
}
