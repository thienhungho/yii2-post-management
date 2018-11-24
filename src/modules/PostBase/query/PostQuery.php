<?php

namespace thienhungho\PostManagement\modules\PostBase\query;

use thienhungho\ActiveQuery\models\ActiveQuery;

/**
 * Class PostQuery
 * @package thienhungho\PostManagement\modules\PostBase\query
 */
class PostQuery extends ActiveQuery
{
    /**
     * @param $status
     *
     * @return $this
     */
    public function status($status)
    {
        if ($status != PARAMS_VALUE_ALL) {
            $this->andWhere(['status' => $status]);
        }

        return $this;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function type($type)
    {
        if ($type != PARAMS_VALUE_ALL) {
            $this->andWhere(['post_type' => $type]);
        }

        return $this;
    }
}
