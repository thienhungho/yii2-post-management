<?php
/**
 * @param $name
 *
 * @return bool
 */
function is_post_type($name)
{
    return \thienhungho\PostManagement\modules\PostBase\PostType::find()
        ->where(['name' => $name])
        ->exists();
}

/**
 * @param $post
 */
function get_post_content($post)
{
    echo $post->content;
}

/**
 * @param $post_type
 * @param $slug
 *
 * @return string
 */
function get_post_url($post_type, $slug)
{
    return url([
        '/post/post/view',
        'type' => $post_type,
        'slug' => $slug,
    ]);
}

/**
 * @param string $data_type
 *
 * @return array|\thienhungho\PostManagement\modules\PostBase\PostType[]|\common\modules\users\PostType[]
 */
function get_all_post_type($data_type = DATA_TYPE_OBJ)
{
    if ($data_type == DATA_TYPE_OBJ) {
        return \thienhungho\PostManagement\modules\PostBase\PostType::find()
            ->all();
    } else {
        return \thienhungho\PostManagement\modules\PostBase\PostType::find()
            ->asArray()
            ->all();
    }
}

/**
 * @param $type
 *
 * @return string
 */
function get_post_type_url($type)
{
    return url([
        '/post/post/index',
        'type' => $type,
    ]);
}

/**
 * @param $term_type
 * @param $term_id
 * @param $post_type
 *
 * @return array
 */
function get_all_post_id_in_term($term_type, $term_id, $post_type)
{
    return get_all_obj_id_in_term($term_type, $term_id, $post_type);
}

/**
 * @param $post_type
 * @param $term_type
 * @param $slug
 *
 * @return string
 */
function get_post_term_url($post_type, $term_type, $slug)
{
    return url([
        '/post/post/term',
        'post_type' => $post_type,
        'term_type' => $term_type,
        'slug'      => $slug,
    ]);
}

/**
 * @param string $type
 * @param int $limit
 * @param string $data_type
 * @param string $status
 * @param array $orderBy
 *
 * @return array|\thienhungho\PostManagement\modules\PostBase\Post[]|\thienhungho\PostManagement\modules\PostBase\query\Post[]
 */
function get_all_post(
    $type = PARAMS_VALUE_ALL,
    $limit = -1,
    $data_type = DATA_TYPE_ARRAY,
    $status = PARAMS_VALUE_ALL,
    $orderBy = ['id' => SORT_DESC]
)
{
    return \thienhungho\PostManagement\modules\PostBase\Post::find()
        ->status($status)
        ->type($type)
        ->orderBy($orderBy)
        ->limit($limit)
        ->dataType($data_type)
        ->all();
}

/**
 * @param string $post_type
 * @param string $status
 *
 * @return int|string
 */
function count_all_post($post_type = PARAMS_VALUE_ALL, $status = PARAMS_VALUE_ALL)
{
    return \thienhungho\PostManagement\modules\PostBase\Post::find()
        ->status($status)
        ->type($post_type)
        ->count();
}

/**
 * @param string $post_type
 * @param $id
 * @param string $status
 *
 * @return int|string
 */
function count_all_comment_of_post($post_type = 'post', $id, $status = STATUS_PUBLIC)
{
    return count_all_comment_of_obj(
        $post_type . '-' . 'comment',
        $post_type,
        $id,
        $status
    );
}

/**
 * @param $post_type
 * @param $id
 * @param string $status
 * @param int $limit
 * @param string $data_type
 *
 * @return array|\thienhungho\CommentManagement\models\Comment[]|\thienhungho\PostManagement\modules\PostBase\query\Comment[]
 */
function get_all_comment_of_post(
    $post_type,
    $id,
    $status = STATUS_PUBLIC,
    $limit = -1,
    $data_type = 'array'
)
{
    return get_all_comment_of_obj(
        $post_type . '-' . 'comment',
        $post_type,
        $id,
        $status,
        $limit,
        $data_type
    );
}

/**
 * @param $post_type
 *
 * @return array|\thienhungho\PostManagement\modules\PostBase\TermOfPostType[]
 */
function get_all_term_type_of_post_type($post_type)
{
    return \thienhungho\PostManagement\modules\PostBase\TermOfPostType::find()
        ->select('name')
        ->where(['post_type' => $post_type])
        ->asArray()
        ->all();
}