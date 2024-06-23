<?php

namespace app\components;

use app\components\onesignal\Notification;
use app\components\onesignal\Player;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class OneSignal extends Component
{
  public $appId;
  public $apiKey;

  public function init()
  {
    if (empty($this->appId)) {
      throw new Exception('Configure onesignal appId!');
    }

    if (empty($this->apiKey)) {
      throw new Exception('Configure onesignal apiKey!');
    }
  }

  private function config()
  {
    return [
      'appId' => $this->appId,
      'apiKey' => $this->apiKey
    ];
  }

  public function players($id = false)
  {
    return new Player(ArrayHelper::merge($this->config(), ['id' => $id]));
  }

  public function notifications($id = false)
  {
    return new Notification(ArrayHelper::merge($this->config(), ['id' => $id]));
  }
}
