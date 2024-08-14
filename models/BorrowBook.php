<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "borrow_book".
 *
 * @property int $id
 * @property string|null $code
 * @property int $information_borrower_book_id
 * @property int $book_id
 * @property string $start
 * @property string $end
 * @property int|null $quantity
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class BorrowBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_BORROWED = 1;
    const STATUS_RETURNED = 0;

    public static function tableName()
    {
        return 'borrow_book';
    }

    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            [['book_id', 'information_borrower_book_id', 'code', 'start', 'end',], 'required'],
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'missing_books', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['status'], 'in', 'range' => [self::STATUS_BORROWED, self::STATUS_RETURNED]],
            [['quantity'], 'number', 'min' => 1, 'max' => 1, 'tooSmall' => 'Quantity must be at least 1.', 'tooBig' => 'Quantity must not exceed 1.'],

            ['quantity', 'validateQuantity'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'information_borrower_book_id' => 'Information Borrower Book ID',
            'missing_books' => 'Missing Books',
            'book_id' => 'Book',
            'start' => 'Start',
            'end' => 'End',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getGrade()
    {
        return $this->hasOne(InfomationBorrowerBook::class, ['grade_id' => 'id'])
            ->via('informationBorrowerBook');
    }

    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public function getInformationBorrowerBook()
    {
        return $this->hasOne(InfomationBorrowerBook::class, ['id' => 'information_borrower_book_id']);
    }

    public function getDaysAgo()
    {
        $endDate = new \DateTime($this->end);
        $currentDate = new \DateTime();
        $interval = $currentDate->diff($endDate);
        return $interval->days;
    }

    // public function borrowBook()
    // {
    //     $book = Book::findOne($this->book_id);
    //     if ($book && $book->quantity > 1) {
    //         $book->updateQuantity(-1); // Decrease quantity by 1
    //         $this->status = self::STATUS_BORROWED;
    //         return $this->save();
    //     }
    //     return false;
    // }

    // public function returnBook()
    // {
    //     $book = Book::findOne($this->book_id);
    //     if ($book && $this->status === self::STATUS_BORROWED) {
    //         $book->updateQuantity(0); 
    //         $this->status = self::STATUS_RETURNED;
    //         return $this->save();
    //     }
    //     return false;
    // }

    public function validateBorrowRequests($postData)
    {
        $errors = [];
        $requestedQuantities = [];

        // Aggregate requested quantities
        foreach ($postData['information_borrower_book_id'] as $key => $informationBorrowerBookID) {
            $bookId = $postData['book_id'][$key];
            $requestedQuantity = (int)$postData['quantity'][$key];

            if (!isset($requestedQuantities[$bookId])) {
                $requestedQuantities[$bookId] = 0;
            }
            $requestedQuantities[$bookId] += $requestedQuantity;
        }

        // Validate against available quantities
        $availableQuantities = Book::getAvailableQuantities(array_keys($requestedQuantities));
        foreach ($requestedQuantities as $bookId => $totalRequested) {
            if (!isset($availableQuantities[$bookId])) {
                $errors[] = "Book with ID $bookId not found.";
                continue;
            }

            if ($totalRequested > $availableQuantities[$bookId]) {
                $errors[] = "Book with ID $bookId only has {$availableQuantities[$bookId]} copies available.";
            }
        }

        return $errors;
    }
   

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
                $this->created_by = Yii::$app->user->identity->id;
            } else {
                $this->updated_at = date('Y-m-d H:i:s');
                $this->updated_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }



    public function getStatusTemp()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-subtle badge-danger">មិនទាន់សង</span>';
        } else {
            return '<span class="badge badge-subtle badge-success">សង់រួចរាល់</span>';
        }
    }
}
