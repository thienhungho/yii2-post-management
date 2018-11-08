<?php

namespace thienhungho\PostManagement\modules\PostManage\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use thienhungho\PostManagement\modules\PostBase\Post;

/**
 * thienhungho\PostManagement\modules\PostManage\search\PostSearch represents the model behind the search form about `thienhungho\PostManagement\modules\PostBase\Post`.
 */
 class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author', 'post_parent', 'assign_with', 'created_by', 'updated_by'], 'integer'],
            [['title', 'slug', 'content', 'feature_img', 'status', 'comment_status', 'post_type', 'language', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'author' => $this->author,
            'post_parent' => $this->post_parent,
            'assign_with' => $this->assign_with,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'feature_img', $this->feature_img])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'comment_status', $this->comment_status])
            ->andFilterWhere(['like', 'post_type', $this->post_type])
            ->andFilterWhere(['like', 'language', $this->language]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
