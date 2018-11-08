<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */

$this->title = t('app', 'Save As New {modelClass}: ', [
    'modelClass' => 'Post',
]). ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Post'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Save As New');
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
