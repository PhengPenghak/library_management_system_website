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
    public $from_date;
    public $to_date;
    public $grade_title;
    public $book_title;
    public $borrower_name;
    public $information_borrower_grade_title;

    public function rules()
    {
        return [
            [['information_borrower_book_id', 'book_id', 'quantity', 'status'], 'required'],
            [['id', 'information_borrower_book_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'start', 'end', 'created_at', 'updated_at', 'username', 'grade_title', 'book_title', 'borrower_name', 'information_borrower_grade_title', 'from_date', 'to_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BorrowBook::find();
        $query->joinWith(['book', 'informationBorrowerBook']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'like', 'grade.title', $this->grade_title,
        ])
            ->andFilterWhere([
                'like', 'book.title', $this->book_title,
            ])
            ->andFilterWhere([
                'like', 'information_borrower_book.name', $this->borrower_name,
            ])
            ->andFilterWhere([
                'like', 'information_borrower_book.grade_title', $this->information_borrower_grade_title,
            ]);

        $query->andFilterWhere(['between', 'DATE(borrow_book.created_at)', $this->from_date, $this->to_date]);


        return $dataProvider;
    }
}
