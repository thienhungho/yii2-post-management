<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\PostType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Post Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-type-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Post Type').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerPost->totalCount){
    $gridColumnPost = [
        ['class' => 'yii\grid\SerialColumn'],         [             'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {                 return ['value' => $data->id];             },         ],
        ['attribute' => 'id', 'visible' => false],
        'title',
        'slug',
        'content:ntext',
        [
                'attribute' => 'author0.username',
                'label' => t('app', 'Author')
            ],
        'feature_img',
        'status',
        'comment_status',
        'post_parent',
                'language',
        'assign_with',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerPost,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(t('app', 'Post')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnPost
    ]);
}
?>
    </div>
</div>
