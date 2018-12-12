<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Post'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Post').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
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
        'post_type',
        'language',
        'assign_with',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
