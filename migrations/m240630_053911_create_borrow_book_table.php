<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%borrow_book}}`.
 */
class m240630_053911_create_borrow_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%borrow_book}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'information_borrower_book_id' => $this->integer(11)->notNull(),
            'book_id' => $this->integer(11)->notNull(),
            'start' => $this->dateTime()->notNull(),
            'end' => $this->dateTime()->notNull(),
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
        $this->dropTable('{{%borrow_book}}');
    }
}
