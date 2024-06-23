<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $user_id
 * @property int $upload_image_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $gender
 * @property string $phone_number
 * @property string|null $address
 * @property string|null $date_of_birth
 * @property int|null $city_id
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['user_id', 'upload_image_id', 'first_name', 'last_name', 'phone_number'], 'required'],
            [['upload_image_id', 'city_id'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['user_id'], 'string', 'max' => 36],
            [['first_name', 'last_name', 'phone_number'], 'string', 'max' => 20],
            [['gender'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'upload_image_id' => 'Upload Image ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'date_of_birth' => 'Date Of Birth',
            'city_id' => 'City ID',
        ];
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
