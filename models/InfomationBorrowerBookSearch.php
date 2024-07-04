<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InfomationBorrowerBook;

/**
 * InfomationBorrowerBookSearch represents the model behind the search form of `app\models\InfomationBorrowerBook`.
 */
class InfomationBorrowerBookSearch extends InfomationBorrowerBook
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'grade_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['username', 'gender', 'created_at', 'updated_at'], 'safe'],
            [['globalSearch'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
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
        $query = InfomationBorrowerBook::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC, 'updated_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'type' => $this->type,
            'status' => $this->status
        ]);

        $query->andFilterWhere([
            'OR',
            ['like', 'name', $this->globalSearch],
        ]);

        return $dataProvider;
    }
}
