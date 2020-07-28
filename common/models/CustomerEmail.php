<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer_emails".
 *
 * @property integer $customer_id
 * @property string $email
 * @property integer $primary
 *
 * @property Customer $customer
 */
class CustomerEmail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_emails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'email'], 'required'],
            [['customer_id', 'primary'], 'integer'],
            [['email'], 'string', 'max' => 50],
            [['email'], 'unique'],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('common', 'Customer ID'),
            'email' => Yii::t('common', 'Email'),
            'primary' => Yii::t('common', 'Primary'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id'])->inverseOf('customerEmails');
    }
}
