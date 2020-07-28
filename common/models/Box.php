<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "boxes".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $photos
 * @property string $price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string[] $aPhotos
 *
 * @property BoxGroup[] $boxGroups
 * @property OrderBox[] $orderBoxes
 */
class Box extends ActiveRecord
{
    public $aPhotos = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boxes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photos'], 'string'],
            [['price'], 'number'],
            [['status', 'created_at', 'updated_at'], 'integer'],
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
            'status' => Yii::t('common', 'Статус'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoxGroups()
    {
        return $this->hasMany(BoxGroup::class, ['box_id' => 'id'])->inverseOf('box');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBoxes()
    {
        return $this->hasMany(OrderBox::class, ['box_id' => 'id'])->inverseOf('box');
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->photos = Json::encode($this->aPhotos);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->aPhotos = $this->photos === null ? [] : Json::decode($this->photos);
        parent::afterFind();
    }
}
