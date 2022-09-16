<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $tag \shop\entities\Shop\Tag */
/* @var $model \shop\forms\manage\Shop\BrandForm */

$this->title = 'Update Tag: ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
