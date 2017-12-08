<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customers".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CustomerEmail[] $customerEmails
 * @property CustomerPhone[] $customerPhones
 * @property Order[] $orders
 */
class Customer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
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
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['surname'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Имя'),
            'surname' => Yii::t('common', 'Фамилия'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'password_hash' => Yii::t('common', 'Password Hash'),
            'password_reset_token' => Yii::t('common', 'Password Reset Token'),
            'created_at' => Yii::t('common', 'Дата создания'),
            'updated_at' => Yii::t('common', 'Дата обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerEmails()
    {
        return $this->hasMany(CustomerEmail::className(), ['customer_id' => 'id'])->inverseOf('customer');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerPhones()
    {
        return $this->hasMany(CustomerPhone::className(), ['customer_id' => 'id'])->inverseOf('customer');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id'])->inverseOf('customer');
    }
}
