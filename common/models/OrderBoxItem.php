<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_box_items".
 *
 * @property string $order_box_id
 * @property integer $item_id
 * @property string $price
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Item $item
 * @property OrderBox $orderBox
 */
class OrderBoxItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_box_items';
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
            [['order_box_id', 'item_id'], 'required'],
            [['order_box_id', 'item_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['order_box_id'], 'unique'],
            [
                ['item_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Item::class,
                'targetAttribute' => ['item_id' => 'id']
            ],
            [
                ['order_box_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => OrderBox::class,
                'targetAttribute' => ['order_box_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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
        return $this->hasOne(Item::class, ['id' => 'item_id'])->inverseOf('orderBoxItems');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBox()
    {
        return $this->hasOne(OrderBox::class, ['id' => 'order_box_id'])->inverseOf('orderBoxItem');
    }
}
