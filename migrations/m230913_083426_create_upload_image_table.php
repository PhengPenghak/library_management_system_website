<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%upload_image}}`.
 */
class m230913_083426_create_upload_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%upload_image}}', [
            'id' => $this->primaryKey(),
            'filename' => $this->string(255),
            'size' => $this->string(50),
            'type' => $this->string(20),
            'path' => $this->string(255),
            'created_at' => $this->dateTime()->defaultExpression("NOW()"),
            'user_id' => $this->string(36),
            'blurhash' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%upload_image}}');
    }
}
