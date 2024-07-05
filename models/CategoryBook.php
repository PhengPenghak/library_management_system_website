<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_book".
 *
 * @property int $id
 * @property string $title
 * @property string|null $sponse
 * @property int|null $quantity
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class CategoryBook extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1, STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'sponse'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'ចំណងជើង',
            'sponse' => 'ប្រភព',
            'quantity' => 'ចំនួនប្រើប្រាស់',
            'status' => 'ស្ថានភាព',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
            return '<span class="badge badge-subtle badge-success">នៅទំនេរ</span>';
        } else {
            return '<span class="badge badge-subtle badge-danger">មិនទំនេរ</span>';
        }
    }
    public function getBookCount()
    {
        return Book::find()->where(['category_book_id' => $this->id])->count();
    }
}
