<?php

use yii\db\Migration;

/**
 * Class m240718_100355_add_column_name_to_table_borrow_book
 */
class m240718_100355_add_column_name_to_table_borrow_book extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%borrow_book}}', 'is_read', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%borrow_book}}', 'is_read', $this->integer());
    }
}
