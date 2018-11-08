<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */

$post_type = request()->get('type', \thienhungho\PostManagement\modules\PostBase\Post::POST_TYPE_POST);
$model->post_type = $post_type;
$this->title = t('app', 'Create New');
$this->params['breadcrumbs'][] = ['label' => t('app', $post_type), 'url' => ['index', 'type' => $post_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
