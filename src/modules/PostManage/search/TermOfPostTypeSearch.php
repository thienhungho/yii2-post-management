<?php

namespace thienhungho\PostManagement\modules\PostManage\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use thienhungho\PostManagement\modules\PostBase\TermOfPostType;

/**
 * thienhungho\PostManagement\modules\PostManage\search\TermOfPostTypeSearch represents the model behind the search form about `thienhungho\PostManagement\modules\PostBase\TermOfPostType`.
 */
 class TermOfPostTypeSearch extends TermOfPostType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'post_type', 'input_type', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = TermOfPostType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'post_type', $this->post_type])
            ->andFilterWhere(['like', 'input_type', $this->input_type]);

        return $dataProvider;
    }
}
