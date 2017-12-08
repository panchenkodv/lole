<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property integer $id
 * @property string $amount_order
 * @property string $amount_due
 * @property integer $customer_id
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderBox[] $orderBoxes
 * @property Customer $customer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount_order', 'amount_due'], 'number'],
            [['customer_id', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'amount_order' => Yii::t('common', 'Сумма заказа'),
            'amount_due' => Yii::t('common', 'Сумма к оплате'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'status_id' => Yii::t('common', 'Статус'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBoxes()
    {
        return $this->hasMany(OrderBox::className(), ['order_id' => 'id'])->inverseOf('order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id'])->inverseOf('orders');
    }
}
