<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('{{users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{users}}');
    }
}
