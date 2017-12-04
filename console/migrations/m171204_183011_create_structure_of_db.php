<?php

use yii\db\Migration;

class m171204_183011_create_structure_of_db extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue(''),
            'surname' => $this->string(30)->notNull()->defaultValue(''),
            'auth_key' => $this->string(32)->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->createTable('{{%customer_phones}}', [
            'customer_id' => $this->integer()->notNull(),
            'phone' => $this->string(12)->unique()->notNull(),
            'primary' => $this->smallInteger(1)->unsigned()->defaultValue(0)
        ]);

        $this->createTable('{{%customer_emails}}', [
            'customer_id' => $this->integer()->notNull(),
            'email' => $this->string(12)->notNull()->unique(),
            'primary' => $this->smallInteger(1)->unsigned()->defaultValue(0)
        ]);

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'amount_order' => $this->money(10, 2)->notNull()->defaultValue(0),
            'amount_due' => $this->money(10, 2)->notNull()->defaultValue(0),
            'customer_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'status_id' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull()
        ]);

        $this->createTable('{{%boxes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'description' => $this->string()->notNull()->defaultValue(''),
            'photos' => 'json NOT NULL',
            'price' => $this->money(10, 2)->notNull()->defaultValue(0),
            'status_id' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull()
        ]);

        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'description' => $this->string()->notNull()->defaultValue(''),
            'photos' => 'json NOT NULL',
            'price_in' => $this->money(10, 2)->notNull()->defaultValue(0),
            'price_out' => $this->money(10, 2)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
