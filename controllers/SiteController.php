<?php

namespace app\controllers;

use app\models\Book;
use app\models\Booking;
use app\models\BorrowBook;
use app\models\BorrowBookSearch;
use app\models\InfomationBorrowerBook;
use app\models\InfomationBorrowerBookSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\MemberJoinedLibrary;
use Codeception\Lib\Connector\Yii2;
use DateTime;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $totalBooksCount = Book::find()->count();
        $borrowedBooksCount = BorrowBook::find()->count();

        $today = '2024-08-07';

        $reminders = [];

        $borrowBooks = BorrowBook::find()
            ->where(['<=', 'DATE(start)', $today])
            ->andWhere(['>=', 'DATE(end)', $today])
            ->all();


        foreach ($borrowBooks as $borrowBook) {
            $borrower = InfomationBorrowerBook::findOne($borrowBook->information_borrower_book_id);

            if ($borrower) {
                $message = "Reminder: You have borrowed the book with ID {$borrowBook->book_id}.\n";
                $message .= "Start Date: {$borrowBook->start}\n";
                $message .= "End Date: {$borrowBook->end}\n";

                $reminders[] = $message;
            }
        }
        $countReminders = count($reminders);

        $searchModel = new BorrowBookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $currentToday = date('Y-m-d');
        $dataProvider->query->andWhere(['<', 'end', $currentToday]);
        $dataProvider->query->andWhere(['=', 'borrow_book.status', 1]);
        $dataProvider->pagination->pageSize = 10;
        $totalCount = $dataProvider->getTotalCount();
        $searchModelOver = new BorrowBookSearch();
        $dataProviderOver = $searchModelOver->search($this->request->queryParams);
        $dataProviderOver->pagination->pageSize = 10;
        $totalCountOver = $dataProviderOver->getTotalCount();
        // $QTYBook = Book::find()->sum('quantity');
        // $availableBooksCount = $QTYBook - $borrowedBooksCount;

        $QTYBook = Book::find()->sum('quantity');

        $borrowedBooksCount = BorrowBook::find()->where(['status' => BorrowBook::STATUS_BORROWED])->sum('quantity');
        $availableBooksCount = $QTYBook - $borrowedBooksCount;


        $memberJoinedLibrary = MemberJoinedLibrary::find()->where(['status' => 1])->sum('total_member');
        return $this->render(
            'index',
            [
                'totalBooksCount' => $totalBooksCount,
                'borrowedBooksCount' => $borrowedBooksCount,
                'availableBooksCount' => $availableBooksCount,
                'reminders' => $reminders,
                'countReminders' => $countReminders,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'totalCount' => $totalCount,
                'searchModelOver' => $searchModelOver,
                'dataProviderOver' => $dataProviderOver,
                'totalCountOver' => $totalCountOver,
                'memberJoinedLibrary' => $memberJoinedLibrary,
                'QTYBook' => $QTYBook
            ]
        );
    }

    public function actionChartData()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $query = (new \yii\db\Query())
            ->select(['MONTH(start) AS month', 'YEAR(start) AS year', 'COUNT(*) AS count'])
            ->from('borrow_book')
            ->groupBy(['YEAR(start)', 'MONTH(start)'])
            ->orderBy(['YEAR(start)' => SORT_ASC, 'MONTH(start)' => SORT_ASC]);

        $data = $query->all();

        $months = [];
        $counts = [];

        $fixedMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        // $fixedMonths = [
        //     'មករា',   // January
        //     'កុម្ភៈ',  // February
        //     'មាមា',   // March
        //     'មេសា',   // April
        //     'ឧសភា',  // May
        //     'មិថុនា', // June
        //     'កក្កដា',  // July
        //     'សីហា',   // August
        //     'តុលា',   // September
        //     'វិច្ឆិកា', // October
        //     'វិច្ឆិកា', // November
        //     'ធ្នូ',    // December
        // ];
        $monthToCount = [];
        foreach ($data as $row) {
            $monthName = date('F', strtotime($row['year'] . '-' . $row['month'] . '-01'));
            $monthKey = array_search($monthName, $fixedMonths);
            if ($monthKey !== false) {
                $monthToCount[$monthKey] = $row['count'];
            }
        }

        // Fill in missing months with zero counts
        foreach ($fixedMonths as $index => $month) {
            $months[] = $month;
            $counts[] = isset($monthToCount[$index]) ? $monthToCount[$index] : 0;
        }

        return [
            'months' => $months,
            'counts' => $counts,
        ];
    }

    // In your controller (e.g., SiteController.php)

    public function actionPieChartData()
    {
        $data = Yii::$app->db->createCommand("
        SELECT 
            type_joined, 
            SUM(total_member) AS total_members 
        FROM member_joined_library 
        GROUP BY type_joined
    ")->queryAll();
        $typeLabels = [
            1 => 'សិស្ស',
            2 => 'គ្រូ',
            3 => 'សមាគមន៏',
        ];

        $labels = [];
        $values = [];
        foreach ($data as $row) {
            $type = (int) $row['type_joined'];
            $labels[] = isset($typeLabels[$type]) ? $typeLabels[$type] : 'Unknown';
            $values[] = (int) $row['total_members'];
        }

        return $this->asJson([
            'labels' => $labels,
            'values' => $values,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'guest_layout';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // public function actionBackup()
    // {
    //     $dbName = 'library_management_system';
    //     $backupFile = Yii::getAlias('@app/backups') . '/library_management_system_' . date('Ymd_His') . '.sql';
    //     if (!is_dir(Yii::getAlias('@app/backups'))) {
    //         mkdir(Yii::getAlias('@app/backups'), 0777, true);
    //     }

    //     $mysqldumpPath = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump';

    //     $command = "$mysqldumpPath -h localhost -u root --routines --triggers --databases $dbName > $backupFile 2>&1";
    //     exec($command, $output, $returnVar);

    //     if ($returnVar === 0) {
    //         Yii::info('Backup successfully created: ' . $backupFile, 'backup');
    //         Yii::$app->session->setFlash('success', 'Backup was successful! Backup file: ' . basename($backupFile));
    //     } else {
    //         Yii::error('Failed to create backup with mysqldump. Output: ' . implode("\n", $output), 'backup');
    //         Yii::$app->session->setFlash('error', 'Backup failed. Please try again.');
    //     }

    //     return $this->redirect(Yii::$app->request->referrer);
    // }


    public function actionBackup()
    {
        $dbName = 'library_management_system';
        $downloadsPath = getenv('HOME') . '/Downloads/backups';

        if (!is_dir($downloadsPath)) {
            mkdir($downloadsPath, 0777, true);
        }

        $backupFile = $downloadsPath . '/library_management_system_' . date('Ymd_His') . '.sql';

        $mysqldumpPath = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump';

        $command = "$mysqldumpPath -h localhost -u root --routines --triggers --databases $dbName > $backupFile 2>&1";
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            Yii::info('Backup successfully created: ' . $backupFile, 'backup');
            Yii::$app->session->setFlash('success', 'បង្កើតទិន្នន័យបម្រុងដោយជោគជ័យ! ឯកសារបម្រុងទុក: ' . basename($backupFile));
        } else {
            Yii::error('Failed to create backup with mysqldump. Output: ' . implode("\n", $output), 'backup');
            Yii::$app->session->setFlash('error', 'Backup failed. Please try again.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}