<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MemberJoinedLibrary;

class MemberJoinedLibrarySearch extends MemberJoinedLibrary
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch, $scheduleType, $selectedDate, $from_date, $to_date;
    public $filter; // Add this property
    public function rules()
    {
        return [
            [['id', 'total_member', 'total_member_female', 'status', 'created_by', 'updated_by'], 'integer'],
            [['type_member', 'type_joined', 'dateTime', 'created_at', 'updated_at', 'globalSearch', 'selectedDate', 'scheduleType', 'from_date', 'to_date'], 'safe'],
            [['filter'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_joined' => $this->type_joined,
        ]);

        $query->andFilterWhere(['like', 'grade.title', $this->globalSearch])
            ->andFilterWhere(['=', 'member_joined_library.status', $this->scheduleType])
            ->andFilterWhere(['like', 'member_joined_library.status', $this->status]);


        $query->andFilterWhere(['between', 'DATE(member_joined_library.dateTime)', $this->from_date, $this->to_date]);

        if ($this->filter === 'this_month') {
            $query->andWhere(['between', 'dateTime', date('Y-m-01'), date('Y-m-t')]);
        } elseif ($this->filter === 'this_year') {
            $query->andWhere(['between', 'dateTime', date('Y-01-01'), date('Y-12-31')]);
        }

        return $dataProvider;
    }
}
