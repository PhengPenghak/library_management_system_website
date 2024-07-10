<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%member_joined_library}}`.
 */
class m240710_065044_create_member_joined_library_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%member_joined_library}}', [
            'id' => $this->primaryKey(),
            'grade_id' => $this->integer()->notNull(),
            'type_member' => $this->integer()->notNull(),
            'total_member' => $this->integer()->notNull(),
            'total_member_female' => $this->integer()->notNull(),
            'dateTime' => $this->dateTime()->notNull(),
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
        $this->dropTable('{{%member_joined_library}}');
    }
}
