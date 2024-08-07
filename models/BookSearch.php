<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form of `app\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch, $categorySearch;
    public $from_date, $to_date;

    public function rules()
    {
        return [
            [['id', 'category_book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['title', 'sponse', 'img_url', 'created_at', 'updated_at'], 'safe'],
            [['globalSearch', 'categorySearch', 'from_date', 'to_date'], 'safe']

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
        $query = Book::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->globalSearch])
            ->andFilterWhere(['like', 'category_book_id', $this->categorySearch])
            ->andFilterWhere(['like', 'status', $this->status]);


        $query->andFilterWhere(['between', 'DATE(book.created_at)', $this->from_date, $this->to_date]);

        return $dataProvider;
    }
}
