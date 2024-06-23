<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
  /**
   * {@inheritdoc}
   */
  public $globalSearch;
  public function rules()
  {
    return [
      [['id', 'role_id', 'status'], 'integer'],
      [['email', 'username', 'password_hash', 'password_reset_token', 'auth_key', 'verification_token'], 'safe'],
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
    $query = User::find()->andWhere(['role_id' => 1]);
    $query->joinWith(['profile']);

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    $query->orFilterWhere(['like', 'user.email', $this->globalSearch])
      ->orFilterWhere(['like', 'user.username', $this->globalSearch])
      ->orFilterWhere(['like', 'user_profile.first_name', $this->globalSearch])
      ->orFilterWhere(['like', 'user_profile.last_name', $this->globalSearch])
      ->orFilterWhere(['like', 'user_profile.phone_number', $this->globalSearch]);

    return $dataProvider;
  }
}
