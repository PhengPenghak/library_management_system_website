<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property int|null $missing_books
 */
class BorrowBook extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
            [['book_id', 'information_borrower_book_id', 'code', 'start', 'end'], 'required'],
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'missing_books', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['quantity'], 'number', 'min' => 1, 'max' => 1, 'tooSmall' => 'Quantity must be at least 1.', 'tooBig' => 'Quantity must not exceed 1.'],
            ['book_id', 'validateBookQuantity'],
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

    /**
     * Validates the book quantity to ensure that the requested quantity does not exceed the available stock.
     */
    public function validateBookQuantity($attribute, $params)
    {
        $book = Book::findOne($this->book_id);
        if ($book && $book->quantity < $this->quantity) {
            $this->addError($attribute, 'The requested quantity exceeds the available stock.');
        }
    }

    /**
     * Get the related Grade model through the InfomationBorrowerBook model.
     */
    public function getGrade()
    {
        return $this->hasOne(InfomationBorrowerBook::class, ['grade_id' => 'id'])
            ->via('informationBorrowerBook');
    }

    /**
     * Get the related Book model.
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Get the related InfomationBorrowerBook model.
     */
    public function getInformationBorrowerBook()
    {
        return $this->hasOne(InfomationBorrowerBook::class, ['id' => 'information_borrower_book_id']);
    }

    /**
     * Get the number of days since the book was borrowed.
     */
    public function getDaysAgo()
    {
        $endDate = new \DateTime($this->end);
        $currentDate = new \DateTime();
        $interval = $currentDate->diff($endDate);
        return $interval->days;
    }

    /**
     * Before save event handler to set timestamps and decrease the quantity of the book in stock.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $currentDateTime = date('Y-m-d H:i:s');
            $currentUser = Yii::$app->user->identity->id;

            if ($this->isNewRecord) {
                $this->created_at = $currentDateTime;
                $this->created_by = $currentUser;

                $book = Book::findOne($this->book_id);
                if ($book) {
                    $book->quantity -= $this->quantity;
                    $book->save(false);
                }
            } else {
                $this->updated_at = $currentDateTime;
                $this->updated_by = $currentUser;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the status label for display.
     */
    public function getStatusTemp()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-subtle badge-danger">មិនទាន់សង</span>';
        } else {
            return '<span class="badge badge-subtle badge-success">សងរួចរាល់</span>';
        }
    }
}
