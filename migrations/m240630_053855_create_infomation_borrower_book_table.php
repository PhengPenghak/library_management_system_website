<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%infomation_borrower_book}}`.
 */
class m240630_053855_create_infomation_borrower_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%infomation_borrower_book}}', [
            'id' => $this->primaryKey(),
            'grade_id' => $this->integer(11)->notNull(),
            'username' => $this->string()->notNull(),
            'gender' => "ENUM('male', 'female') NOT NULL DEFAULT 'male'",
            'status' => $this->tinyInteger(1),
            'created_at' => $this->dateTime()->defaultExpression("NOW()"),
            'updated_at' => $this->dateTime()->defaultExpression("NOW()"),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%infomation_borrower_book}}');
    }
}
