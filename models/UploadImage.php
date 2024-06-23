<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_image".
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $filename
 * @property string $type
 * @property int $size
 * @property string $path
 * @property string $blurhash
 * @property string $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class UploadImage extends \yii\db\ActiveRecord
{
  /** @var \yii\web\UploadedFile|null $file */
  public $imageFile;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'upload_image';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['filename', 'type', 'size', 'path', 'user_id', 'created_at'], 'required'],
      [['size', 'vendor_id'], 'integer'],
      [['filename', 'type', 'path'], 'string', 'max' => 255],
      [['user_id'], 'string', 'max' => 36],
      [
        ['imageFile'], 'file',
        'skipOnEmpty' => true,
        'extensions' => 'jpg, jpeg, gif, png, webp',
        'maxSize' => 1024 * 1024 * 2
      ],
      [['created_at'], 'safe']
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'filename' => 'Filename',
      'type' => 'Type',
      'size' => 'Size',
      'path' => 'Path',
      'blurhash' => 'Blurhash',
      'user_id' => 'User ID',
      'created_at' => 'Created At',
    ];
  }

  /**
   * Upload file to S3 and save to database
   * @return boolean
   */
  public function upload()
  {
    /** @var \app\components\AwsSdk $awssdk */
    $awssdk = Yii::$app->awssdk;
    $key = $awssdk->generateKey($this->imageFile->name);

    $awssdk->upload([
      'Key' => $key,
      "Body" => $this->imageFile->name,
      'SourceFile' => $this->imageFile->tempName,
      'ACL' => 'public-read',
      'ContentType' => 'image/png'
    ]);

    $this->filename = $this->imageFile->name;
    $this->size = $this->imageFile->size;
    $this->type = $this->imageFile->type;
    $this->path = $key;
    $this->user_id = Yii::$app->user->identity->id;
    $this->created_at = date("Y-m-d H:i:s");
    $this->imageFile = null;

    return $this->save();
  }
}
