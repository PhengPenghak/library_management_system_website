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
            // [['book_id', 'start', 'end'], 'required'],
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['end', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
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
}
