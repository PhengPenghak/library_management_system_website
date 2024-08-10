<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member_joined_library".
 *
 * @property int $id
 * @property string $type_member
 * @property int $total_member
 * @property int $total_member_female
 * @property string $dateTime
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MemberJoinedLibrary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    // public $title;
    public static function tableName()
    {
        return 'member_joined_library';
    }

    /**
     * {@inheritdoc}
     */
    public $month_and_year;
    public function rules()
    {
        return [
            [['total_member', 'type_joined', 'total_member_female', 'dateTime'], 'required'],
            [['grade_id', 'type_joined', 'total_member', 'total_member_female', 'status', 'created_by', 'updated_by'], 'integer'],
            [['dateTime', 'created_at', 'updated_at'], 'safe'],
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
            'type_joined' => 'Type Joined',
            'type_member' => 'Type Member',
            'total_member' => 'Total Member',
            'total_member_female' => 'Total Member Female',
            'dateTime' => 'Date Time',
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
            return '<span class="badge badge-subtle badge-success">ចូលអានតាមកាលវិភាគ</span>';
        } else {
            return '<span class="badge badge-subtle badge-warning">ចូលអានសេរី</span>';
        }
    }
    public function getJionType()
    {
        if ($this->type_joined == 1) {
            return 'សិស្ស';
        }
        if ($this->type_joined == 2) {
            return 'គ្រូ';
        } else {
            return 'សមាគមន៍';
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
