<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\TermOfPostType */

$this->title = t('app', 'Create Term Of Post Type');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term Of Post Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-of-post-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
