<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $photos
 * @property string $price_in
 * @property string $price_out
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderBoxItem[] $orderBoxItems
 * @property OrderBox[] $orderBoxes
 */
class Item extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photos'], 'string'],
            [['price_in', 'price_out'], 'number'],
            [['count', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Название'),
            'description' => Yii::t('common', 'Описание'),
            'photos' => Yii::t('common', 'Photos'),
            'price_in' => Yii::t('common', 'Цена закупки'),
            'price_out' => Yii::t('common', 'Цена продажи'),
            'count' => Yii::t('common', 'Количество'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBoxItems()
    {
        return $this->hasMany(OrderBoxItem::className(), ['item_id' => 'id'])->inverseOf('item');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBoxes()
    {
        return $this->hasMany(OrderBox::className(), ['id' => 'order_box_id'])
            ->viaTable('order_box_items', ['item_id' => 'id']);
    }
}
