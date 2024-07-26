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
    public $gradeTitle;
    public $globalSearch, $from_date, $to_date;


    public function rules()
    {
        return [
            [['id', 'grade_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['username', 'gender', 'created_at', 'updated_at'], 'safe'],
            [['globalSearch', 'from_date', 'to_date'], 'safe']


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
        $query->joinWith('grade');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['username' => SORT_ASC]]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['between', 'DATE(infomation_borrower_book.created_at)', $this->from_date, $this->to_date])
            ->andFilterWhere([
                'OR',
                ['like', 'infomation_borrower_book.username', $this->globalSearch],
            ]);
        return $dataProvider;
    }

    public static function getGradeList()
    {
        $grades = Grade::find()->all();
        return ArrayHelper::map($grades, 'id', 'title');
    }
}
