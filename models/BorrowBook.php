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
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['quantity'], 'number', 'min' => 1, 'max' => 1, 'tooSmall' => 'Quantity must be at least 1.', 'tooBig' => 'Quantity must not exceed 3.'],

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
            'book_id' => 'Book ID',
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
    public function getStatusTemp()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-subtle badge-danger">មិនទាន់សង</span>';
        } else {
            return '<span class="badge badge-subtle badge-success">សង់រួចរាល់</span>';
        }
    }
}
