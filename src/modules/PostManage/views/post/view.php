<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostBase\Post */
$this->title = $model->title;
$this->params['breadcrumbs'][] = [
    'label' => t('app', $model->post_type),
    'url'   => [
        'index',
        'type' => $model->post_type,
    ],
];
$this->params['breadcrumbs'][] = $this->title;
$seo = \common\modules\seo\Seo::find()->where(['obj_id' => $model->primaryKey])->andWhere(['obj_type' => $model->post_type])->one();
?>
<div class="post-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= t('app', $model->post_type) . ' ' . Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?=
            Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . t('app', 'PDF'),
                [
                    'pdf',
                    'id' => $model->id,
                ],
                [
                    'class'       => 'btn btn-danger',
                    'target'      => '_blank',
                    'data-toggle' => 'tooltip',
                    'title'       => t('app', 'Will open the generated PDF file in a new window'),
                ]
            ) ?>
            <?= Html::a(t('app', 'Save As New'), [
                'save-as-new',
                'id' => $model->id,
            ], ['class' => 'btn btn-info']) ?>
            <?= Html::a(t('app', 'Update'), [
                'update',
                'id' => $model->id,
            ], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(t('app', 'Delete'), [
                'delete',
                'id' => $model->id,
            ], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => t('app', 'Are you sure you want to delete this item?'),
                    'method'  => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <?php
        $gridColumn = [
            [
                'attribute' => 'id',
                'visible'   => false,
            ],
            'title',
            'slug',
            'content:raw',
            [
                'attribute' => 'author0.username',
                'label'     => t('app', 'Author'),
            ],
            'feature_img',
            'status',
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
            //        'post_type',
            //        'language',
            //        'assign_with',
        ];
        echo DetailView::widget([
            'model'      => $model,
            'attributes' => $gridColumn,
        ]);
        ?>
    </div>
    <!--    <div class="row">-->
    <!--        <h4>User--><? //= ' '. Html::encode($this->title) ?><!--</h4>-->
    <!--    </div>-->
    <!--    --><?php //
    //    $gridColumnUser = [
    //        ['attribute' => 'id', 'visible' => false],
    //        'username',
    //        'auth_key',
    //        'password_hash',
    //        'password_reset_token',
    //        'email',
    //        'full_name',
    //        'job',
    //        'bio',
    //        'company',
    //        'tax_number',
    //        'address',
    //        'avatar',
    //        'phone',
    //        'birth_date',
    //        'facebook_url',
    //        'status',
    //    ];
    //    echo DetailView::widget([
    //        'model' => $model->author0,
    //        'attributes' => $gridColumnUser    ]);
    //    ?>
</div>
