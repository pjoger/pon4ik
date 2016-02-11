<?php

use yii\db\Schema;
use yii\db\Migration;

class m160130_123459_create_project extends Migration
{
    private $TableName = 'project';
    private $OrderTable = 'order';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->TableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(64),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'description' => $this->text(),
            'created_at' => Schema::TYPE_TIMESTAMP.' NOT NULL default CURRENT_TIMESTAMP',
            'closed_at' => Schema::TYPE_TIMESTAMP.' NULL',
        ], $tableOptions);
        $this->createIndex('idx-'.$this->TableName.'-user_id', $this->TableName, 'user_id');
        if ($this->db->driverName === 'mysql') {
          $this->addForeignKey('fk_'.$this->TableName.'_user_id', $this->TableName, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        }
        // свяжем order с project
        $this->addColumn($this->OrderTable, $this->TableName.'_id', $this->integer()->notNull().' AFTER user_id');
        $this->createIndex(
          'idx-'.$this->OrderTable.'-'.$this->TableName.'_id', $this->OrderTable,
          [$this->TableName.'_id', 'closed_at', 'user_id']
        );
        if ($this->db->driverName === 'mysql') {
          $this->addForeignKey(
            'fk-'.$this->OrderTable.'-'.$this->TableName.'_id',
            $this->OrderTable,
            $this->TableName.'_id',
            $this->TableName,
            'id',
            'CASCADE', 'CASCADE'
          );
        }
    }

    public function down()
    {
      $this->dropForeignKey('fk-'.$this->OrderTable.'-'.$this->TableName.'_id', $this->OrderTable);
      $this->dropIndex('idx-'.$this->OrderTable.'-'.$this->TableName.'_id', $this->OrderTable);
      $this->dropColumn($this->OrderTable, $this->TableName.'_id');
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
