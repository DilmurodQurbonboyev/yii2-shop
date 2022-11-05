<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model shop\forms\manage\Shop\Product\PriceForm */
/* @var $product shop\entities\Shop\Product\Product */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>
<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'old')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>