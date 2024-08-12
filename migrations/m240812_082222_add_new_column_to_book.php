<?php

use yii\db\Migration;

/**
 * Class m240812_082222_add_new_column_to_book
 */
class m240812_082222_add_new_column_to_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('book', 'publishing', $this->string());
        $this->addColumn('book', 'publishing_date', $this->date());
    }

    public function down()
    {
        $this->dropColumn('book', 'publishing');
        $this->dropColumn('book', 'publishing_date');
    }
}
