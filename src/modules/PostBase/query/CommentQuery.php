<?php

namespace thienhungho\PostManagement\modules\PostBase\query;

/**
 * This is the ActiveQuery class for [[\thienhungho\PostManagement\modules\PostBase\query\Comment]].
 *
 * @see \thienhungho\PostManagement\modules\PostBase\query\Comment
 */
class CommentQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \thienhungho\PostManagement\modules\PostBase\query\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \thienhungho\PostManagement\modules\PostBase\query\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
