<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model cmsbase\modules\PostBase\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', slug_to_text($model->post_type)), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if (file_exists(__DIR__ . '/post-type/' . $model->post_type . '.php')) {
    echo $this->render('post-type/'. $model->post_type, [
        'model' => $model
    ]);
} else {
    echo $this->render('post-type/post', [
        'model' => $model
    ]);
}
