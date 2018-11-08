<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\PostType */

$this->title = t('app', 'Create Post Type');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Post Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
