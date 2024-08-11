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
    public $month_and_year;
    public function rules()
    {
        return [
            [['id', 'total_member', 'total_member_female', 'status', 'created_by', 'updated_by'], 'integer'],
            [['type_member', 'type_joined', 'dateTime', 'created_at', 'updated_at', 'globalSearch', 'selectedDate', 'scheduleType', 'from_date', 'to_date'], 'safe'],
            [['month_and_year'], 'safe'],
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
            ->joinWith('grade') // Eager load the related `grade` model
            ->select([
                'member_joined_library.id', // Select fields you want to include
                'member_joined_library.type_joined',
                'member_joined_library.status',
                'grade.title', // Include fields from the related `grade` model
                'COUNT(member_joined_library.id) AS total_count', // Example aggregation
            ])
            ->groupBy(['member_joined_library.id', 'grade.title']); // Group by `id` and `title`


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
        return $dataProvider;
    }
}
