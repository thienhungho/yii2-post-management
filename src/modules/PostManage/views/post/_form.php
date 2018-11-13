<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="row post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'post_type', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="col-lg-9 col-xs-12">
        <?= $form->field($model, 'title', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-edit"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Title'),
        ])->hint(Yii::t('app', 'Title should not exceed 255 characters')) ?>

        <?=
        $form->field($model, 'content', [
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->widget(froala\froalaeditor\FroalaEditorWidget::className(), [
            'clientOptions' => [
                'toolbarInline'         => false,
                'language'              => substr(Yii::$app->language, 0, 2),
                'height'                => '500px',
                'fontFamilySelection'   => true,
                'fontSizeSelection'     => true,
                'videoAllowedProviders' => [
                    'youtube',
                    'vimeo',
                    'facebook',
                ],
                'videoInsertButtons'    => [
                    'videoBack',
                    '|',
                    'videoByURL',
                ],
                'imageUploadParam'      => 'file',
                'imageUploadURL'        => \yii\helpers\Url::to(['/upload']),
            ],
        ])->hint(Yii::t('app', 'Content is King'));
        ?>

        <?= $form->field($model, 'feature_img', [
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->fileInput()->widget(\kartik\file\FileInput::classname(), [
            'options'       => ['accept' => 'image/*'],
            'pluginOptions' => empty($model->feature_img) ? [] : [
                'initialPreview'       => [
                    '/' . $model->feature_img,
                ],
                'initialPreviewAsData' => true,
                'initialCaption'       => $model->feature_img,
                'overwriteInitial'     => true,
            ],
        ])->hint(Yii::t('app', 'Feature Img, submit your img')) ?>

    </div>

    <div class="col-lg-3 col-xs-12">

        <?= $form->field($model, 'status', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-eye"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->radioButtonGroup([
            STATUS_PUBLIC  => t('app', slug_to_text(STATUS_PUBLIC)),
            STATUS_PENDING => t('app', slug_to_text(STATUS_PENDING)),
            STATUS_DRAFT   => t('app', slug_to_text(STATUS_DRAFT)),
        ], [
            'class'       => 'btn-group-sm',
            'itemOptions' => ['labelOptions' => ['class' => 'btn green']],
        ])->hint(Yii::t('app', 'The public status, whether the article is displayed on the homepage or not')) ?>

        <?= $form->field($model, 'comment_status', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-comment"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->radioButtonGroup([
            STATUS_ENABLE  => t('app', slug_to_text(STATUS_ENABLE)),
            STATUS_DISABLE => t('app', slug_to_text(STATUS_DISABLE)),
        ], [
            'class'       => 'btn-group-sm',
            'itemOptions' => ['labelOptions' => ['class' => 'btn green']],
        ])->hint(Yii::t('app', 'The comment status, whether the article is enable or disable comment')) ?>

        <?= $form->field($model, 'author', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(
                \thienhungho\UserManagement\models\User::find()
                    ->orderBy('id')
                    ->asArray()
                    ->all(), 'id', 'username'
            ),
            'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->hint(Yii::t('app', 'Choose author for this article')) ?>

        <?= $form->field($model, 'post_parent', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(
                \thienhungho\PostManagement\modules\PostBase\Post::find()
                    ->select([
                        'id',
                        'title',
                    ])
                    ->where(['post_parent' => 0])
                    ->andWhere(['post_type' => $model->post_type])
                    ->andWhere([
                        '!=',
                        'id',
                        $model->id,
                    ])
                    ->orderBy('id')
                    ->asArray()
                    ->all(), 'id', 'title'
            ),
            'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => t('app', 'Post Parent')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->hint(Yii::t('app', 'Choose parent article for this article')) ?>

        <?php
        if (is_enable_multiple_language()) {
            echo language_select_input($form, $model, 'language');
            echo $form->field($model, 'assign_with', [
                'addon' => ['prepend' => ['content' => '<span class="fa fa-paperclip"></span>']],
                'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
                'hintSettings' => [
                    'showIcon' => true,
                    'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
                ],
            ])->widget(\kartik\widgets\Select2::classname(), [
                'data'          => \yii\helpers\ArrayHelper::map(
                    \thienhungho\PostManagement\modules\PostBase\Post::find()
                        ->select([
                            'id',
                            'title',
                        ])
                        ->orderBy('id')
                        ->where(['assign_with' => 0])
                        ->andWhere(['post_type' => $model->post_type])
                        ->andWhere([
                            '!=',
                            'id',
                            $model->id,
                        ])
                        ->asArray()
                        ->all(), 'id', 'title'
                ),
                'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => t('app', 'Assign With')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->hint(Yii::t('app', 'Choose assign articles'));
        }
        ?>

        <?php
        $termTypes = get_all_term_type_of_post_type($model->post_type);
        foreach ($termTypes as $termType) { ?>
            <div class="form-group">
                <label class="category-label"><?= t('app', ucfirst($termType['name'])) ?></label>
                <?=
                \kartik\widgets\Select2::widget([
                    'addon'         => ['prepend' => ['content' => '<span class="fa fa-paperclip"></span>']],
                    'name'          => 'term_data_' . $termType['name'] . '[]',
                    'value'         => get_all_term_name_of_obj($model->post_type, $model->primaryKey, $termType['name']),
                    'data'          => \yii\helpers\ArrayHelper::map(
                        \thienhungho\TermManagement\modules\TermBase\Term::find()
                            ->select('name')
                            ->orderBy('id')
                            ->asArray()
                            ->where(['term_type' => $termType['name']])
                            ->all(), 'name', 'name'
                    ),
                    'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                    'options'       => [
                        'multiple'    => true,
                        'placeholder' => t('app', 'Choose') . ' ' . t('app', slug_to_text($termType['name'])),
                    ],
                    'pluginOptions' => [
                        'allowClear'         => true,
                        'tags'               => true,
                        'tokenSeparators'    => [','],
                        'maximumInputLength' => 225,
                    ],
                ])
                ?>
            </div>
        <?php }
        ?>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
                <?= Html::submitButton(
                    $model->isNewRecord ?
                        t('app', 'Create') :
                        t('app', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?><?php endif; ?><?php if (Yii::$app->controller->action->id != 'create'): ?>
                <?= Html::submitButton(t('app', 'Save As New'), [
                    'class' => 'btn btn-info',
                    'value' => '1',
                    'name'  => '_asnew',
                ]) ?><?php endif; ?>
            <?= Html::a(t('app', 'Cancel'),
                request()->referrer, ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
