<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */
?>
<div class="post-view">

    <div class="row">
        <div class="col-sm-9">
            <h3><?= Html::encode($model->title) ?></h3>
        </div>
    </div>

    <div class="row">
        <?php
        $gridColumn = [
            [
                'attribute' => 'id',
                'visible'   => false,
            ],
            'slug',
            'content:raw',
            [
                'format'              => 'raw',
                'attribute'           => 'comment_status',
                'value'               => function($model, $key) {
                    if ($model->comment_status == STATUS_DISABLE) {
                        return '<span class="label-danger label">' . t('app', slug_to_text(STATUS_DISABLE)) . '</span>';
                    } elseif ($model->comment_status == STATUS_ENABLE) {
                        return '<span class="label-success label">' . t('app', slug_to_text(STATUS_ENABLE)) . '</span>';
                    }
                }
            ],
            [
                'format'              => 'raw',
                'attribute'           => 'post_parent',
                'value'               => function($model, $key) {
                    if ($model->post_parent == 0) {
                        return null;
                    }

                    return Html::a($model->post_parent, \yii\helpers\Url::to(['view', 'id' => $model->post_parent]));
                }
            ],
        ];
        echo DetailView::widget([
            'model'      => $model,
            'attributes' => $gridColumn,
        ]);
        ?>
    </div>
</div>