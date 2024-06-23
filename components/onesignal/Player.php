<?php

namespace app\components\onesignal;

use yii\base\Exception;
use yii\helpers\ArrayHelper;

class Player extends \yii\web\Request
{
  public $id;
  public $methodName = 'players';
  public $endpoint = 'players';

  public function getAll($params = null)
  {
    $query = ArrayHelper::merge($params, ['app_id' => $this->appId]);

    $response = $this->client->request(
      'GET',
      $this->endpoint,
      ['query' => $query]
    );

    return json_decode($response->getBody(), true);
  }

  public function getOne()
  {
    $response = $this->client->request(
      'GET',
      $this->endpoint . '/' . $this->id,
      ['query' => [
        'app_id' => $this->appId
      ]]
    );

    return json_decode($response->getBody(), true);
  }

  public function edit(array $options = null)
  {
    if (!$this->id)
      throw new Exception('ID of player is not defined');

    $response = $this->client->request(
      'PUT',
      $this->endpoint . '/' . $this->id,
      ['form_params' => ArrayHelper::merge($options, ['app_id' => $this->appId])]
    );

    return json_decode($response->getBody(), true);
  }

  public function addTag($tagName, $tagValue = true)
  {
    if (is_array($tagName)) {
      return $this->edit(['tags' => $tagName]);
    } else {
      return $this->edit(['tags' => [$tagName => $tagValue]]);
    }
  }

  public function removeTag($tagName)
  {
    return $this->addTag($tagName, '');
  }
}
