<?php

namespace thienhungho\PostManagement\models;

use \thienhungho\PostManagement\modules\PostBase\Post as BasePost;

/**
 * This is the model class for table "post".
 */
class Post extends BasePost
{
    public $beforeContent;

    public $afterContent;

    public function renderContent()
    {
        return $this->beforeContent . $this->content . $this->afterContent;
    }
}
