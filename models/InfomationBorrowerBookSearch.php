<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InfomationBorrowerBook;
use yii\helpers\ArrayHelper;

/**
 * InfomationBorrowerBookSearch represents the model behind the search form of `app\models\InfomationBorrowerBook`.
 */
class InfomationBorrowerBookSearch extends InfomationBorrowerBook
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch, $gradeTitle;

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
        $query = InfomationBorrowerBook::find()->joinWith('grade');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['username' => SORT_ASC]]
        ]);

        $dataProvider->sort->attributes['gradeTitle'] = [
            'asc' => ['grade.title' => SORT_ASC],
            'desc' => ['grade.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'grade_id' => $this->grade_id,
            'status' => $this->status,
            // Add other filters here
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'grade.title', $this->gradeTitle]); // Add filter condition for grade title

        return $dataProvider;
    }

    public static function getGradeList()
    {
        $grades = Grade::find()->all();
        return ArrayHelper::map($grades, 'id', 'title');
    }
}
