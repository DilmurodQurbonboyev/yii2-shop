<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use shop\entities\Shop\Tag;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function (Tag $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw'
                    ],
                    'slug',
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>
