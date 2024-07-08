<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%}}`.
 */
class m240527_134543_add_new_column_to_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_role}}', 'is_master', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user_role}}', 'is_master', $this->integer());
    }
}
