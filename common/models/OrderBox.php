<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_boxes}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $box_id
 * @property string $price
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderBoxItem[] $orderBoxItems
 * @property Box $box
 * @property Order $order
 */
class OrderBox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_boxes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'box_id', 'created_at', 'updated_at'], 'required'],
            [['order_id', 'box_id', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['box_id'], 'exist', 'skipOnError' => true, 'targetClass' => Box::className(), 'targetAttribute' => ['box_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_id' => Yii::t('common', 'Order ID'),
            'box_id' => Yii::t('common', 'Box ID'),
            'price' => Yii::t('common', 'Цена'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBoxItems()
    {
        return $this->hasMany(OrderBoxItem::className(), ['order_box_id' => 'id'])->inverseOf('orderBox');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBox()
    {
        return $this->hasOne(Box::className(), ['id' => 'box_id'])->inverseOf('orderBoxes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id'])->inverseOf('orderBoxes');
    }
}
