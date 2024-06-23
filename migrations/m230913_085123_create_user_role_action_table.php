<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_role_action}}`.
 */
class m230913_085123_create_user_role_action_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_role_action}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(),
            'name' => $this->string(50),
            'controller' => $this->string(50),
            'action' => $this->text(),
            'status' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_role_action}}');
    }
}
