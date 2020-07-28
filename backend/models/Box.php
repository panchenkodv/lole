<?php

namespace backend\models;

use backend\behaviors\PhotoBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Box
 * @package backend\models
 * @inheritdoc
 */
class Box extends \common\models\Box
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => PhotoBehavior::class,
                'storePath' => 'store/images/boxes'
            ]
        ];
    }
}
