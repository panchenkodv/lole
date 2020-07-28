<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderBox */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Order Box',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Order Boxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="order-box-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
