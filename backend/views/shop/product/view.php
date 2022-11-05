<?php

use backend\helpers\PriceHelper;
use kartik\file\FileInput;
use shop\entities\Shop\Product\Modification;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product \shop\entities\Shop\Product\Product */
/* @var $modificationsProvider  Modification */
/* @var $photosForm  \shop\forms\manage\Shop\Product\PhotosForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $product->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Common</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'brand_id',
                                'value' => ArrayHelper::getValue($product, 'brand.name'),
//                                'value' => $product->brand->name,
                            ],
                            'code',
                            'name',
                            [
                                'attribute' => 'price_new',
                                'value' => PriceHelper::format($product->price_new),
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => PriceHelper::format($product->price_old),
                            ],
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name')
                            ],
                            [
                                'label' => 'Other categories',
                                'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name'))
                            ],
                            [
                                'label' => 'Tags',
                                'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name'))
                            ],
                        ],
                    ]) ?>
                    <br>
                    <p>
                        <?= Html::a('change price', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Characteristics</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => array_map(function (\shop\entities\Shop\Product\Value $value){
                            return [
                                'label' => $value->characteristic->name,
                                'value' => $value->value,
                            ];
                        }, $product->values),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">Description</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($product->description) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border" id="modifications">Modifications</div>
        <div class="box-body">
            <p><?= Html::a('Add modification',
                    ['shop/modification/create', 'product_id' => $product->id],
                    ['class' => 'btn btn-primary']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $modificationsProvider,
                'columns' => [
                    'code',
                    'name',
                    [
                        'attribute' => 'price',
                        'value' => function(Modification $model){
                            return PriceHelper::format($model->price);
                        },
                    ],
                    [
                        'class' => \yii\grid\ActionColumn::class,
                        'controller' => 'shop/modification',
                        'template' => '{update} {delete}'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box" id="photos">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <div class="row">
                <?php foreach($product->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left">',
                                ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove">',
                                ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right">',
                                ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]) ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $form = ActiveForm::begin([
                'options' => ['encrypt' => 'multipart/form-data']
            ]) ?>
            <?= $form->field($photosForm, 'files[]')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>


            <div class="form-group">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>