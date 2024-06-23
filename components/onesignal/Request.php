<?php

namespace app\components\onesignal;

use yii\base\BaseObject;
use GuzzleHttp\Client;

class Request extends BaseObject
{

  public $client;
  public $appId;
  public $apiKey;
  public $apiBaseUrl = 'https://onesignal.com/api/v1/';

  public function init()
  {
    $this->client = new Client([
      'base_uri' => $this->apiBaseUrl,
      'headers' => [
        'Authorization' => 'Basic ' . $this->apiKey,
        'Content-Type' => 'application/json'
      ]
    ]);
  }
}
