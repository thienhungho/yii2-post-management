<?php

namespace thienhungho\PostManagement\modules\PostBase;

use Yii;
use \thienhungho\PostManagement\modules\PostBase\base\TermOfPostType as BaseTermOfPostType;

/**
 * This is the model class for table "term_of_post_type".
 */
class TermOfPostType extends BaseTermOfPostType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'post_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'post_type', 'input_type'], 'string', 'max' => 255]
        ]);
    }
	
}
