<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_distribution_by_grade}}`.
 */
class m240706_153447_create_book_distribution_by_grade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_distribution_by_grade}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'information_distribution_by_grade' => $this->integer(11)->notNull(),
            'book_id' => $this->integer(11)->notNull(),
            'start' => $this->date()->notNull(),
            'end' => $this->date()->notNull(),
            'quantity' => $this->integer(),
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
