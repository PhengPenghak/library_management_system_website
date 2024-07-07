<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InfomationBookDistributionByGrade;

/**
 * InfomationBorrowerBookSearch represents the model behind the search form of `app\models\InfomationBorrowerBook`.
 */
class InfomationBookDistributionByGradeSearch extends InfomationBookDistributionByGrade
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
        $query = InfomationBookDistributionByGrade::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['username' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->globalSearch])
            ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }
}
