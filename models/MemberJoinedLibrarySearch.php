<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MemberJoinedLibrary;

/**
 * MemberJoinedLibrarySearch represents the model behind the search form of `app\models\MemberJoinedLibrary`.
 */
class MemberJoinedLibrarySearch extends MemberJoinedLibrary
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch, $scheduleType;
    public function rules()
    {
        return [
            [['id', 'total_member', 'total_member_female', 'status', 'created_by', 'updated_by'], 'integer'],
            [['type_member', 'dateTime', 'created_at', 'updated_at', 'globalSearch'], 'safe'],
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
        $query = MemberJoinedLibrary::find()
            ->joinWith('grade');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'grade.title', $this->globalSearch])
            ->andFilterWhere(['=', 'member_joined_library.status', $this->scheduleType]);

        return $dataProvider;
    }
}
