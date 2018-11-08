<?php

namespace thienhungho\PostManagement\modules\PostBase;

use Yii;
use \thienhungho\PostManagement\modules\PostBase\base\PostType as BasePostType;

/**
 * This is the model class for table "post_type".
 */
class PostType extends BasePostType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ]);
    }
	
}
