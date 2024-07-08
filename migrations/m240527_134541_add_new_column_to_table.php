<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%}}`.
 */
class m240527_134541_add_new_column_to_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'user_type_id', $this->integer());
        $this->addColumn('{{%user}}', 'first_name', $this->string());
        $this->addColumn('{{%user}}', 'last_name', $this->string());
        $this->addColumn('{{%user}}', 'mobile', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'user_type_id', $this->integer());
        $this->addColumn('{{%user}}', 'first_name', $this->string());
        $this->addColumn('{{%user}}', 'last_name', $this->string());
        $this->addColumn('{{%user}}', 'mobile', $this->string());
    }
}
