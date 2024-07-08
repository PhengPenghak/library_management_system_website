<?php

namespace app\controllers;

use app\models\Book;
use app\models\Booking;
use app\models\BorrowBook;
use app\models\InfomationBorrowerBook;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

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
        $availableBooksCount = $totalBooksCount - $borrowedBooksCount;

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


        return $this->render(
            'index',
            [
                'totalBooksCount' => $totalBooksCount,
                'borrowedBooksCount' => $borrowedBooksCount,
                'availableBooksCount' => $availableBooksCount,
                'reminders' => $reminders,
                'countReminders' => $countReminders

            ]
        );
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

    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionSendNotifications()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $notifications = BorrowBook::find()
            ->where(['<=', '2024-07-11 19:22:00', $currentDateTime])
            ->andWhere(['>=', '2024-07-08 09:32:00', $currentDateTime])
            ->all();

        echo "<pre>";
        print_r($notifications);
        echo "</pre>";
        exit;

        foreach ($notifications as $notification) {
            Yii::$app->session->setFlash('alert', $notification->id);
            echo "Notification sent: {$notification->id}" . PHP_EOL;
        }
    }
}
