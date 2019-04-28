<?php

namespace thienhungho\PostManagement\modules\PostBase;

use \thienhungho\PostManagement\modules\PostBase\base\Post as BasePost;

/**
 * This is the model class for table "post".
 */
class Post extends BasePost
{
    const POST_TYPE_POST = 'post';
    const POST_FEATURE_IMG_INPUT_NAME = 'Post[feature_img]';

    /**
     * @return array
     */
    public function behaviors()
    {
        parent::behaviors();
        return [
            [
                'class'         => 'yii\behaviors\SluggableBehavior',
                'attribute'     => 'title',
                'immutable'     => true,
                'ensureUnique'  => true,
                'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'slug', 'content'], 'required'],
            [['content'], 'string'],
            [['author', 'post_parent', 'assign_with', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'feature_img', 'status', 'post_type', 'language'], 'string', 'max' => 255],
            [['comment_status'], 'string', 'max' => 25],
            [['slug'], 'unique'],
            [['comment_status'], 'default', 'value' => STATUS_ENABLE],
            [['status'], 'default', 'value' => STATUS_PUBLIC],
            [['post_type'], 'default', 'value' => self::POST_TYPE_POST],
            [['assign_with'], 'default', 'value' => 0],
            [['post_parent'], 'default', 'value' => 0],
            [['created_by'], 'default', 'value' => get_current_user_id(), 'on' => 'insert'],
            [['updated_by'], 'default', 'value' => get_current_user_id()],
            [['author'], 'default', 'value' => get_current_user_id()],
            [['language'], 'default', 'value' => get_primary_language()],
            [['feature_img'], 'default', 'value' => DEFAULT_FEATURE_IMG],
        ]);
    }

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $img = upload_img(self::POST_FEATURE_IMG_INPUT_NAME , false);
            if (!empty($img)) {
                $this->feature_img = $img;
            } elseif(empty($img) && !$this->isNewRecord) {
                $model = static::findOne(['id' => $this->id]);
                if ($model) {
                    $this->feature_img = $model->feature_img;
                }
            }

            return true;
        }

        return false;
    }

}
