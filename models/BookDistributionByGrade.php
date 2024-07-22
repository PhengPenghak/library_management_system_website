<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_distribution_by_grade".
 *
 * @property int $id
 * @property string $code
 * @property int $information_distribution_by_grade
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
class BookDistributionByGrade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_distribution_by_grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['information_distribution_by_grade_id', 'book_id', 'start', 'end'], 'required'],
            [['information_distribution_by_grade_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],

            [['quantity'], 'number', 'min' => 1, 'max' => 2000, 'tooSmall' => 'Quantity must be at least 1.', 'tooBig' => 'Quantity must not exceed 3.'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'លេខសារពើភ័ណ្ខ',
            'information_distribution_by_grade_id' => 'Information Distribution By Grade',
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
