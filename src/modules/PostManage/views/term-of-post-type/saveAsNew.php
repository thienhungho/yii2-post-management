<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\TermOfPostType */

$this->title = t('app', 'Save As New {modelClass}: ', [
    'modelClass' => 'Term Of Post Type',
]). ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term Of Post Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Save As New');
?>
<div class="term-of-post-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
