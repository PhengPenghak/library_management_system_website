<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%location_book}}`.
 */
class m240629_1610311_create_location_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%location_book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
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
        $this->dropTable('{{%location_book}}');
    }
}
