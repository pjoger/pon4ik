<?php

use yii\db\Schema;
use yii\db\Migration;

class m160130_140222_mk_anonimous extends Migration
{
    public function up()
    {
        // создадим анонимуса
        $this->insert('user', [
            'id' => '0',
            'username' => 'Anonimous',
            'auth_key' => 'FAIL',
            'password_hash' => 'FAIL',
            'password_reset_token' => 'FAIL',
            'email' => 'FAIL',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->update('user', ['id' => 0], 'id=:old_id', [':old_id' => Yii::$app->db->getLastInsertID()]);
    }

    public function down()
    {
        $this->delete('user','id=0');
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
