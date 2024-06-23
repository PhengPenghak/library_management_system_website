<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPassowrd extends Model
{
  public $vendor_id;
  public $new_password;
  public $secret_code;

  public function rules()
  {
    return [
      [['vendor_id', 'new_password', 'secret_code'], 'required'],
      [['vendor_id'], 'integer'],
      [['secret_code', 'new_password'], 'string', 'min' => 6],
    ];
  }

  public function attributeLabels()
  {
    return [
      'vendor_id' => 'Vendor',
      'new_password' => 'New Password',
      'secret_code' => 'Secret Code',
    ];
  }
}
