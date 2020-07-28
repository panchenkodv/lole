<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_boxes".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $box_id
 * @property string $price
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderBoxItem $orderBoxItems
 * @property Item[] $items
 * @property Box $box
 * @property Order $order
 */
class OrderBox extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_boxes';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'box_id'], 'required'],
            [['id', 'order_id', 'box_id', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['id'], 'unique'],
            [
                ['box_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Box::class,
                'targetAttribute' => ['box_id' => 'id']
            ],
            [
                ['order_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Order::class,
                'targetAttribute' => ['order_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID собранной коробки'),
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
        return $this->hasOne(OrderBoxItem::class, ['order_box_id' => 'id'])->inverseOf('orderBox');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])
            ->viaTable('order_box_items', ['order_box_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBox()
    {
        return $this->hasOne(Box::class, ['id' => 'box_id'])->inverseOf('orderBoxes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id'])->inverseOf('orderBoxes');
    }
}
