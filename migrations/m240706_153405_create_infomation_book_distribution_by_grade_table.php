<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_distribution_by_grade}}`.
 */
class m240706_153405_create_infomation_book_distribution_by_grade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%infomation_book_distribution_by_grade}}', [
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
        $this->dropTable('{{%book_distribution_by_grade}}');
    }
}
