<?php

use yii\db\Migration;

/**
 * Class m230913_085317_create_user_role_group_tabel
 */
class m230913_085317_create_user_role_group_tabel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_role_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'sort' => $this->integer(),
           
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230913_085317_create_user_role_group_tabel cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230913_085317_create_user_role_group_tabel cannot be reverted.\n";

        return false;
    }
    */
}
