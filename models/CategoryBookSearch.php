<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CategoryBook;

/**
 * CategoryBookSearch represents the model behind the search form of `app\models\CategoryBook`.
 */
class CategoryBookSearch extends CategoryBook
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['title', 'sponse', 'created_at', 'updated_at', 'globalSearch'], 'safe'],
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
        $query = CategoryBook::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'title', $this->globalSearch]);

        return $dataProvider;
    }
}
