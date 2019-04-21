<?php

namespace thienhungho\PostManagement\models;

use thienhungho\PostManagement\models\Post;

/**
 * This is the model class for table "post".
 */
class PostRender extends Post
{
    public $beforeContent;

    public $afterContent;

    public function renderContent()
    {
        return $this . $this->beforeContent . $this->content . $this->afterContent;
    }
}
