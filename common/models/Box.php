<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%boxes}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $photos
 * @property string $price
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderBox[] $orderBoxes
 */
class Box extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%boxes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photos'], 'string'],
            [['price'], 'number'],
            [['status_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
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
            'price' => Yii::t('common', 'Цена'),
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
        return $this->hasMany(OrderBox::className(), ['box_id' => 'id'])->inverseOf('box');
    }
}
