<?php

use yii\db\Schema;
use yii\db\Migration;

class m160213_223729_alter_project extends Migration
{
    private $TableName = 'project';

    public function up()
    {
      $this->alterColumn($this->TableName, 'price','decimal(15,2) unsigned NOT NULL default 0');
      $this->addColumn($this->TableName, 'collected', 'decimal(15,2) unsigned NOT NULL default 0 after price');
    }

    public function down()
    {
        $this->dropColumn($this->TableName,'collected');
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
