<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */

if (empty($model->post_type)) {
    $model->post_type = request()->get('type', \thienhungho\PostManagement\modules\PostBase\Post::POST_TYPE_POST);
}
$this->title = t('app', 'Save As New Language {modelClass}: ', [
        'modelClass' => t('app', $model->post_type),
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => t('app', t('app', $model->post_type)), 'url' => ['index', 'type' => $model->post_type]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Save As New Language');
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_save_as_new_language', [
        'model' => $model,
    ]) ?>

</div>
