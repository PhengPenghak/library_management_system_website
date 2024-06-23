<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m230913_084741_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->string(36),
            'upload_image_id' => $this->integer(),
            'first_name' => $this->string(),
            'first_name' => $this->string(20),
            'last_name' => $this->string(20),
            'gender' => $this->string(10),
            'phone_number' => $this->string(20),
            'address' => $this->string(255),
            'date_of_birth' => $this->date(),
            'city_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
    }
}
