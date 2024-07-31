<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grade;

/**
 * GradeSearch represents the model behind the search form of `app\models\Grade`.
 */
class GradeSearch extends Grade
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch, $from_date, $to_date;

    public function rules()
    {
        return [
            [['id',  'status', 'created_by', 'updated_by'], 'integer'],
            [['title', 'created_at', 'updated_at', 'globalSearch', 'from_date', 'to_date'], 'safe'],
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
        $query = Grade::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->orFilterWhere(['like', 'title', $this->globalSearch]);
        $query->andFilterWhere(['between', 'DATE(grade.created_at)', $this->from_date, $this->to_date]);
        return $dataProvider;
    }
}
