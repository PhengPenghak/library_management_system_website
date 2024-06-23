<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * ImageBlurhash
 * @property string $blurhash
 * @property string $url
 * @property array $options
 */
class ImageBlurhash extends Widget
{
  public $blurhash;
  public $url;

  /**
   * @param array $options the tag options in terms of name-value pairs. These will be rendered as
   * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
   * If a value is null, the corresponding attribute will not be rendered.
   * See [[renderTagAttributes()]] for details on how attributes are being rendered.
   */
  public $options = [];

  public function init()
  {
    parent::init();

    if (!isset($this->options['style'])) {
      $this->options['style'] = '';
    }
  }

  public function run()
  {
    $imageencoded = $this->getImageFromBlurhash($this->blurhash);
    $options = ArrayHelper::merge($this->options, [
      'style' => 'object-fit:cover; background-size: cover; background-image: url(' . $imageencoded . ');' . $this->options['style'],
    ]);

    echo Html::img($this->url, $options);
  }

  public function getImageFromBlurhash($blurhash)
  {
    ob_start();
    imagepng(Yii::$app->blurhash->decode($blurhash));
    // Capture the output and clear the output buffer
    $imageencoded = base64_encode(ob_get_clean());

    return 'data:image/png;base64,' . $imageencoded;
  }
}
