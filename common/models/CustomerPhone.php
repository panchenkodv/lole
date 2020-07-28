<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer_phones".
 *
 * @property integer $customer_id
 * @property string $phone
 * @property integer $primary
 *
 * @property Customer $customer
 */
class CustomerPhone extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_phones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'phone'], 'required'],
            [['customer_id', 'primary'], 'integer'],
            [['phone'], 'string', 'max' => 12],
            [['phone'], 'unique'],
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
            'phone' => Yii::t('common', 'Телефон'),
            'primary' => Yii::t('common', 'Primary'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id'])->inverseOf('customerPhones');
    }
}
