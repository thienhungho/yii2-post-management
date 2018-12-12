<?php

use thienhungho\Widgets\models\GridView;
use yii\helpers\Html;

view()->params['breadcrumbs'][] = view()->title;
?>

<div class="post-index-head">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(t('app', 'Create New'), [
                    'create',
                    'type' => $post_type,
                ], ['class' => 'btn btn-success']) ?>
                <?= Html::a(t('app', 'Advance Search'), '#', [
                    'class' => 'btn btn-info search-button',
                ]) ?>
            </p>
        </div>
        <div class="col-lg-2">
            <?php backend_per_page_form() ?>
        </div>
    </div>
    <div class="search-form" style="display:none">
        <?= $this->render('_search', [
            'model'     => $searchModel,
            'post_type' => $post_type,
        ]); ?>
    </div>
</div>


<?= Html::beginForm(['bulk']) ?>
<div class="post-index">
    <?php
    $gridColumn = [
        grid_serial_column(),
        grid_checkbox_column(),
        [
            'class'         => 'kartik\grid\ExpandRowColumn',
            'width'         => '50px',
            'value'         => function($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'        => function($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
        ],
        grid_hidden_column('id'),
        [
            'class'     => \yii\grid\DataColumn::className(),
            'format'    => 'raw',
            'attribute' => 'feature_img',
            'value'     => function($model, $key, $index, $column) {
                return Html::a(
                    '<img style="max-width: 50px;" src=/' . get_other_img_size_path('thumbnail', $model->feature_img) . '>',
                    \yii\helpers\Url::to([
                        'view',
                        'id' => $model->id,
                    ]), [
                    'data-pjax' => '0',
                ]);
            },
        ],
        [
            'class'         => \yii\grid\DataColumn::className(),
            'format'        => 'raw',
            'attribute'     => 'title',
            'value'         => function($model, $key, $index, $column) {
                return Html::a($model->title, \yii\helpers\Url::to([
                    'view',
                    'id' => $model->id,
                ]), [
                    'data-pjax' => '0',
                ]);
            },
            'headerOptions' => ['style' => 'min-width:222px;'],
        ],
        [
            'attribute'           => 'author',
            'label'               => t('app', 'Author'),
            'value'               => function($model) {
                if ($model->author0) {
                    return $model->author0->username;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()
                ->asArray()
                ->all(), 'id', 'username'
            ),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'User'),
                'id'          => 'grid-post-search-author',
            ],
        ],
        [
            'format'              => 'raw',
            'attribute'           => 'status',
            'value'               => function($model, $key, $index, $column) {
                if ($model->status == STATUS_PENDING) {
                    return '<span class="label-warning label">' . t('app', slug_to_text(STATUS_PENDING)) . '</span>';
                } elseif ($model->status == STATUS_PUBLIC) {
                    return '<span class="label-success label">' . t('app', slug_to_text(STATUS_PUBLIC)) . '</span>';
                } elseif ($model->status == STATUS_DRAFT) {
                    return '<span class="label-danger label">' . t('app', slug_to_text(STATUS_DRAFT)) . '</span>';
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map([
                [
                    'value' => STATUS_PENDING,
                    'name'  => t('app', slug_to_text(STATUS_PENDING)),
                ],
                [
                    'value' => STATUS_PUBLIC,
                    'name'  => t('app', slug_to_text(STATUS_PUBLIC)),
                ],
                [
                    'value' => STATUS_DRAFT,
                    'name'  => t('app', slug_to_text(STATUS_DRAFT)),
                ],
            ], 'value', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Status'),
                'id'          => 'grid-search-status',
            ],
        ],
        [
            'format'        => [
                'date',
                'php:Y-m-d h:s:i',
            ],
            'attribute'     => 'created_at',
            'filterType'    => GridView::FILTER_DATETIME,
            'headerOptions' => ['style' => 'min-width:150px;'],
        ],
    ];
    ?>

    <?php
    $activeButton = grid_view_default_active_column_cofig();
    $activeButton['buttons']['get-path'] = function($url, $model, $key) {
        return '<a title="' . t('app', 'Get Path') . '" onclick="prompt(\'Url: \', \'' . $_SERVER['HTTP_HOST'] . '/' . $model->post_type . "/" . $model->slug . ".html" . '\' )"><span class="btn btn-xs grey-cascade"><span class="fa fa-link"></span></span></a>';
    };
    if (is_enable_multiple_language()) {
        $gridColumn[] = grid_language_column();
        $gridColumn[] = [
            'attribute'           => 'assign_with',
            'label'               => t('app', 'Assign With'),
            'value'               => function($model) {
                if ($model->assign_with) {
                    return $model->assign_with;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(\thienhungho\PostManagement\modules\PostBase\Post::find()
                ->asArray()
                ->all(), 'id', 'title'
            ),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Post'),
                'id'          => 'grid-post-search-assign-with',
            ],
        ];
        $activeButton['width'] = '262px';
        $activeButton['headerOptions'] = ['style' => 'min-width:262px;'];
        $activeButton['template'] = '{save-as-new-language} {save-as-new} {get-path} {view} {update} {delete}';
        $activeButton['buttons']['save-as-new-language'] = function($url) {
            return Html::a('<span class="btn btn-xs green"><span class="fa fa-language"></span></span>', $url, ['title' => t('app', 'Save As New Language')]);
        };
    } else {
        $activeButton['width'] = '222px';
        $activeButton['headerOptions'] = ['style' => 'min-width:222px;'];
        $activeButton['template'] = '{get-path} {save-as-new} {view} {update} {delete}';
    }
    $gridColumn[] = $activeButton;
    ?>

    <?= GridView::widget([
        'dataProvider'   => $dataProvider,
        'filterModel'    => $searchModel,
        'columns'        => $gridColumn,
        'responsiveWrap' => false,
        'condensed'      => true,
        'hover'          => true,
        'pjax'           => true,
        'pjaxSettings'   => ['options' => ['id' => 'kv-pjax-container-post']],
        'panel'          => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'toolbar'        => grid_view_toolbar_config($dataProvider, $gridColumn),
    ]); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= \kartik\widgets\Select2::widget([
                'name'    => 'action',
                'data'    => [
                    ACTION_DELETE  => t('app', 'Delete'),
                    STATUS_DRAFT   => t('app', slug_to_text(STATUS_DRAFT)),
                    STATUS_PENDING => t('app', slug_to_text(STATUS_PENDING)),
                    STATUS_PUBLIC  => t('app', slug_to_text(STATUS_PUBLIC)),
                ],
                'theme'   => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                'options' => [
                    'multiple'    => false,
                    'placeholder' => t('app', 'Bulk Actions ...'),
                ],
            ]); ?>
        </div>
        <div class="col-lg-10">
            <?= Html::submitButton(t('app', 'Apply'), [
                'class'        => 'btn btn-primary',
                'data-confirm' => t('app', 'Are you want to do this?'),
            ]) ?>
        </div>
    </div>

</div>

<?= Html::endForm() ?>
