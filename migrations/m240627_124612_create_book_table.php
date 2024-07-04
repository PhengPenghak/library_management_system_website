<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m240627_124612_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'category_book_id' => $this->integer(11)->notNull(),
            'location_id' => $this->integer(11)->notNull(),
            'title' => $this->string()->notNull(),
            'author' => $this->string(),
            'sponse' => $this->string(),
            'img_url' => $this->string(),
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
        $this->dropTable('{{%book}}');
    }
}
