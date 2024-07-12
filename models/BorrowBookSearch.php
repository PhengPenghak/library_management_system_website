<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BorrowBook;

/**
 * BorrowBookSearch represents the model behind the search form of `app\models\BorrowBook`.
 */
class BorrowBookSearch extends BorrowBook
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch, $from_date, $to_date;
    public $username;

    public $dateRange;

    public function rules()
    {
        return [
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'start', 'end'], 'required'],
            [['id', 'information_borrower_book_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'start', 'end', 'created_at', 'updated_at', 'username'], 'safe'],

            [['globalSearch', 'from_date', 'to_date'], 'safe'],
            [['dateRange'], 'safe'],

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
        $query = BorrowBook::find()
            ->joinWith('informationBorrowerBook')
            ->joinWith('informationBorrowerBook.grade')
            ->joinWith('book');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        if ($this->dateRange) {
            list($startDate, $endDate) = explode(' - ', $this->dateRange);
            $query->andFilterWhere(['between', 'start', $startDate, $endDate]);
            $query->andFilterWhere(['between', 'end', $startDate, $endDate]);
        }


        // $query->andFilterWhere(['between', 'DATE(borrow_book.created_at)', $this->from_date, $this->to_date])
        //     ->andFilterWhere([
        //         'OR',
        //         ['like', 'borrow_book.title', $this->globalSearch],
        //         ['like', 'borrow_book.code', $this->globalSearch],

        //     ]);

        // if ($this->globalSearch) {
        //     $query->andFilterWhere([
        //         'OR',
        //         ['like', 'borrow_book.title', $this->globalSearch],
        //         ['like', 'infomation_borrower_book.username', $this->globalSearch],
        //         ['like', 'borrow_book.code', $this->globalSearch],

        //     ]);
        // }

        return $dataProvider;
    }
}
