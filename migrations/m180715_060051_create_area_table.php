<?php

use yii\db\Migration;

/**
 * Handles the creation of table `area`.
 */
class m180715_060051_create_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('area', [
            'area_id' => $this->primaryKey(),
            'name' => $this->string(250),
            'region_id' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('area');
    }
}
