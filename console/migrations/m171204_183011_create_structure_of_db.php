<?php

use yii\db\Migration;

class m171204_183011_create_structure_of_db extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue('')->comment('Имя'),
            'surname' => $this->string(30)->notNull()->defaultValue('')->comment('Фамилия'),
            'auth_key' => $this->string(32)->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления'),
        ]);

        $this->createTable('{{%customer_phones}}', [
            'customer_id' => $this->integer()->notNull(),
            'phone' => $this->string(12)->unique()->notNull()->comment('Телефон'),
            'primary' => $this->smallInteger(1)->unsigned()->defaultValue(0)
        ]);

        $this->createTable('{{%customer_emails}}', [
            'customer_id' => $this->integer()->notNull(),
            'email' => $this->string(12)->notNull()->unique()->comment('Email'),
            'primary' => $this->smallInteger(1)->unsigned()->defaultValue(0)
        ]);

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'amount_order' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Сумма заказа'),
            'amount_due' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Сумма к оплате'),
            'customer_id' => $this->integer()->notNull()->defaultValue(0),
            'status_id' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('Статус'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления')
        ]);

        $this->createTable('{{%boxes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue('')->comment('Название'),
            'description' => $this->string()->notNull()->defaultValue('')->comment('Описание'),
            'photos' => "json",
            'price' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Цена'),
            'status_id' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('Статус'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления')
        ]);

        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->defaultValue('')->comment('Название'),
            'description' => $this->string()->notNull()->defaultValue('')->comment('Описание'),
            'photos' => "json",
            'price_in' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Цена закупки'),
            'price_out' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Цена продажи'),
            'count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Количество'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления')
        ]);

        $this->createTable('{{%order_boxes}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'box_id' => $this->integer()->notNull(),
            'price' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Цена'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления')
        ]);

        $this->createTable('{{%order_box_items}}', [
            'id' => $this->primaryKey(),
            'order_box_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'price' => $this->money(10, 2)->notNull()->defaultValue(0)->comment('Цена'),
            'count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Количество'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Дата обновления')
        ]);

        $this->addForeignKey(
            'order_box_items_to_order_boxes',
            '{{%order_box_items}}',
            'order_box_id',
            '{{%order_boxes}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'order_box_items_to_items',
            '{{%order_box_items}}',
            'item_id',
            '{{%items}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'order_boxes_to_orders',
            '{{%order_boxes}}',
            'order_id',
            '{{%orders}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'order_boxes_to_boxes',
            '{{%order_boxes}}',
            'box_id',
            '{{%boxes}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'orders_to_customers',
            '{{%orders}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'customer_phones_to_customers',
            '{{%customer_phones}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'customer_emails_to_customers',
            '{{%customer_emails}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('customer_emails_to_customers', '{{%customer_emails}}');
        $this->dropForeignKey('customer_phones_to_customers', '{{%customer_phones}}');
        $this->dropForeignKey('orders_to_customers', '{{%orders}}');
        $this->dropForeignKey('order_boxes_to_boxes', '{{%order_boxes}}');
        $this->dropForeignKey('order_boxes_to_orders', '{{%order_boxes}}');
        $this->dropForeignKey('order_box_items_to_items', '{{%order_box_items}}');
        $this->dropForeignKey('order_box_items_to_order_boxes', '{{%order_box_items}}');
        $this->dropTable('{{%customer_emails}}');
        $this->dropTable('{{%customer_phones}}');
        $this->dropTable('{{%order_box_items}}');
        $this->dropTable('{{%order_boxes}}');
        $this->dropTable('{{%orders}}');
        $this->dropTable('{{%boxes}}');
        $this->dropTable('{{%items}}');
        $this->dropTable('{{%customers}}');
    }
}
