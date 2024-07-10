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
    public function rules()
    {
        return [
            [['information_borrower_book_id', 'book_id', 'quantity', 'status', 'start', 'end'], 'required'],
            [['id', 'information_borrower_book_id', 'book_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'start', 'end', 'created_at', 'updated_at'], 'safe'],


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
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
