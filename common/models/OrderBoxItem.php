<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_box_items}}".
 *
 * @property integer $id
 * @property integer $order_box_id
 * @property integer $item_id
 * @property string $price
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Item $item
 * @property OrderBox $orderBox
 */
class OrderBoxItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_box_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_box_id', 'item_id', 'created_at', 'updated_at'], 'required'],
            [['order_box_id', 'item_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['order_box_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderBox::className(), 'targetAttribute' => ['order_box_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_box_id' => Yii::t('common', 'Order Box ID'),
            'item_id' => Yii::t('common', 'Item ID'),
            'price' => Yii::t('common', 'Цена'),
            'count' => Yii::t('common', 'Количество'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id'])->inverseOf('orderBoxItems');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBox()
    {
        return $this->hasOne(OrderBox::className(), ['id' => 'order_box_id'])->inverseOf('orderBoxItems');
    }
}
