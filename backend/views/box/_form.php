<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Box */
/* @var $form yii\widgets\ActiveForm */

/*$boxPhotos = Yii::$app->getSession()->get('photos')['boxes'] ?? null;
echo '<pre>';
print_r($boxPhotos);
die();*/
?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->isNewRecord ? Html::hiddenInput('preId', Yii::$app->getSecurity()->generateRandomString()) : '' ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photos')->widget(FileInput::class, [
        'language' => 'ru',
        'options' => [
            'accept' => 'image/*',
            'multiple' => true
        ],
        'pluginOptions' => [
            'previewFileType' => 'image',
            'initialPreviewAsData' => true,
            'initialPreview' => array_map(function ($photo) {
                return "/store/images/boxes/{$photo}";
            }, $model->aPhotos),
            'uploadUrl' => Url::to(['/box/add-photo', 'id' => $model->id]),
            'deleteUrl' => Url::to(['/box/delete-photo', 'id' => $model->id]),
            'uploadExtraData' => [
                'preId' => $model->isNewRecord ? Yii::$app->getSecurity()->generateRandomString() : null,
            ],
            'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
            'msgInvalidFileExtension' => \Yii::t(
                'backend',
                'Only `png`, `jpg` and `jpeg` files are allowed.'
            ),
        ]
    ]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
