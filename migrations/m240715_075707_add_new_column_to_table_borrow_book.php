<?php

use yii\db\Migration;

/**
 * Class m240715_075707_add_new_column_to_table_borrow_book
 */
class m240715_075707_add_new_column_to_table_borrow_book extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%borrow_book}}', 'missing_books', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%borrow_book}}', 'missing_books', $this->integer());
    }
}
