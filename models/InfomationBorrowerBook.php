<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "infomation_borrower_book".
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
class InfomationBorrowerBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infomation_borrower_book';
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
            'grade_id' => 'Grade ID',
            'username' => 'Username',
            'gender' => 'Gender',
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
            return '<span class="badge badge-pill badge-info">Publish</span>';
        } else {
            return '<span class="badge badge-pill badge-danger">Inactive</span>';
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
