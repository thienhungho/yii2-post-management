<?php

namespace thienhungho\PostManagement\migrations;

use yii\db\Schema;

class m181108_120101_term_of_post_type extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%term_of_post_type}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->notNull(),
            'post_type'  => $this->string(255)->notNull(),
            'input_type' => $this->string(255)->notNull()->defaultValue('text'),
            'created_at' => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by' => $this->integer(19),
            'updated_by' => $this->integer(19),
            'FOREIGN KEY ([[post_type]]) REFERENCES {{%post_type}} ([[name]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%term_of_post_type}}');
    }
}
