<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_book}}`.
 */
class m240627_124624_create_category_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'sponse' => $this->string(),
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
        $this->dropTable('{{%category_book}}');
    }
}
