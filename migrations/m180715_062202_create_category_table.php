<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180715_062202_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'category_id' => $this->primaryKey(),
            'name' => $this->string(250),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
