<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BorrowBook;

class BorrowBookSearch extends BorrowBook
{
    public $from_date;
    public $to_date;
    public $grade_title;
    public $book_title;
    public $borrower_name;
    public $information_borrower_grade_title;
    public $month_and_year;


    public function rules()
    {
        return [
            [['information_borrower_book_id', 'book_id', 'quantity', 'status'], 'integer'],
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['code', 'start', 'end', 'created_at', 'updated_at', 'username', 'grade_title', 'book_title', 'borrower_name', 'information_borrower_grade_title', 'from_date', 'to_date', 'month_and_year'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BorrowBook::find()->where(['borrow_book.status' => 1]);
        $query->joinWith(['book', 'informationBorrowerBook'])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filters
        $query->andFilterWhere([
            'information_borrower_book_id' => $this->information_borrower_book_id,
            'book_id' => $this->book_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
        ]);

        // Date range filter
        if ($this->from_date && $this->to_date) {
            $query->andFilterWhere(['between', 'DATE(borrow_book.start)', $this->from_date, $this->to_date]);
        }

        $query->andFilterWhere(['like', 'grade.title', $this->grade_title])
            ->andFilterWhere(['like', 'book.title', $this->book_title])
            ->andFilterWhere(['like', 'information_borrower_book.name', $this->borrower_name])
            ->andFilterWhere(['like', 'information_borrower_book.grade_title', $this->information_borrower_grade_title]);

        return $dataProvider;
    }
}
