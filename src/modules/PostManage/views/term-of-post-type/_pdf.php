<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\TermOfPostType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term Of Post Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-of-post-type-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Term Of Post Type').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        [
                'attribute' => 'postType.name',
                'label' => t('app', 'Post Type')
            ],
        'input_type',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
