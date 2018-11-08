<?php

namespace thienhungho\PostManagement\migrations;

use yii\db\Schema;

class m181108_120101_post extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'author' => $this->integer(19),
            'feature_img' => $this->string(255),
            'status' => $this->string(255)->defaultValue('public'),
            'comment_status' => $this->string(25)->defaultValue('open'),
            'post_parent' => $this->integer(19),
            'post_type' => $this->string(255),
            'language' => $this->string(255),
            'assign_with' => $this->integer(19),
            'created_at' => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by' => $this->integer(19),
            'updated_by' => $this->integer(19),
            'FOREIGN KEY ([[author]]) REFERENCES {{%user}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[post_type]]) REFERENCES {{%post_type}} ([[name]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
