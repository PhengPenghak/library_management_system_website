<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int $category_book_id
 * @property string $title
 * @property string|null $sponse
 * @property string|null $img_url
 * @property int|null $quantity
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['category_book_id', 'location_id', 'title'], 'required'],
            [['category_book_id', 'location_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'sponse', 'img_url', 'author'], 'string', 'max' => 255],
            [
                ['imageFile'], 'image',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, jpeg, gif, png, webp',
                'maxSize' => 1024 * 1024 * 2
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_book_id' => 'Category Book',
            'location_id' => 'Location Book',
            'title' => 'Title',
            'sponse' => 'Sponse',
            'img_url' => 'Img Url',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'author' => 'Author'
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $folderPath = "upload/book/";
            $directory = Yii::getAlias("@app/web/") . $folderPath;
            if (!is_dir($directory)) {
                \yii\helpers\FileHelper::createDirectory($directory);
            }
            $randomString =  Yii::$app->security->generateRandomString(16);
            $pathImage = "{$folderPath}{$this->imageFile->baseName}_{$randomString}.{$this->imageFile->extension}";
            $this->imageFile->saveAs($pathImage);
            $this->img_url = $pathImage;
            return true;
        } else {
            return false;
        }
    }
    public function getThumb()
    {
        if (!$this->img_url) return Yii::getAlias("@web/img/not_found_sq.png");
        return Yii::getAlias('@web/') . $this->img_url;
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


    public function getCategoryBook()
    {
        return $this->hasOne(CategoryBook::class, ['id' => 'category_book_id']);
    }

    public function getLocationBook()
    {
        return $this->hasOne(LocationBook::class, ['id' => 'location_id']);
    }
}
