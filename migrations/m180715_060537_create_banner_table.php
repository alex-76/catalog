<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banner`.
 */
class m180715_060537_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('banner', [
            'banner_id' => $this->primaryKey(),
            'name_company' => $this->string(250),
            'date_begin' => $this->datetime(),
            'date_end' => $this->datetime(),
            'url' => $this->string(250),
            'attributes' => $this->string(250),
            'position' => $this->tinyInteger(4),
            'accsess' => "ENUM('0', '1')",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banner');
    }
}
