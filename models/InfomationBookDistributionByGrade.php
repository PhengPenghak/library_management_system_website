<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "infomation_book_distribution_by_grade".
 *
 * @property int $id
 * @property int $grade_id
 * @property string $username
 * @property string $gender
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class InfomationBookDistributionByGrade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infomation_book_distribution_by_grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade_id', 'username'], 'required'],
            [['grade_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['gender'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade_id' => 'ថ្នាក់',
            'username' => 'ឈ្មោះ​អ្នកប្រើប្រាស់',
            'gender' => 'ភេទ',
            'status' => 'Status',
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



    public function getGrade()
    {
        return $this->hasOne(Grade::class, ['id' => 'grade_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
