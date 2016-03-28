<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_115923_orders extends Migration
{
    private $TableName = 'order';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->TableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'type' => $this->smallInteger(2)->notNull()->defaultValue(1),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'transaction' => $this->string(64),
            'created_at' => Schema::TYPE_TIMESTAMP.' NOT NULL default CURRENT_TIMESTAMP',
            'closed_at' => Schema::TYPE_TIMESTAMP.' NULL',
            'error_msg' => $this->string(256),
        ], $tableOptions);
        $this->createIndex(
                'idx-'.$this->TableName.'-user_id',$this->TableName,
                ['user_id','closed_at']
              );
        if ($this->db->driverName === 'mysql') {
          $this->addForeignKey('fk-'.$this->TableName.'-user_id', $this->TableName, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        }
    }

    public function down()
    {
        $this->dropTable($this->TableName);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
