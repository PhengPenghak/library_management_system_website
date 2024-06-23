<?php

namespace app\components;

use kornrunner\Blurhash\Blurhash;
use yii\base\Component;

class AppBlurhash extends Component
{

  /**
   * @param string $imagePath
   * @param int $components_x Default value `4`
   * @param int $components_y Default value `3`
   * @param bool $linear Default value `false`
   * @return string
   */
  public static function encode(string $imagePath, int $components_x = 4, int $components_y = 3, bool $linear = false)
  {
    $image = imagecreatefromstring(file_get_contents($imagePath));
    $width = imagesx($image);
    $height = imagesy($image);

    // resize the image to save processing if larger than $max_width:
    $max_width = 50;
    if ($width > $max_width) {
      $image = imagescale($image, $max_width);
      $width = imagesx($image);
      $height = imagesy($image);
    }


    $pixels = [];
    for ($y = 0; $y < $height; ++$y) {
      $row = [];
      for ($x = 0; $x < $width; ++$x) {
        $index = imagecolorat($image, $x, $y);
        $colors = imagecolorsforindex($image, $index);

        $row[] = [$colors['red'], $colors['green'], $colors['blue']];
      }
      $pixels[] = $row;
    }

    return Blurhash::encode($pixels, $components_x, $components_y, $linear);
  }

  /**
   * @param string $blurhash
   * @param int $width
   * @param int $height
   * @param bool $linear
   * @return string
   * @example $blurhash
   * ```php
   * $image = AppBlurhash::decode('BHWwcA', 100, 100);
   * imagepng($image, 'blurhash.png');
   * ```
   */
  public static function decode(
    string $blurhash,
    int $width = 50,
    int $height = 50,
    float $punch = 1.0,
    bool $linear = false
  ) {

    $pixels = Blurhash::decode($blurhash, $width, $height, $punch, $linear);
    $image  = imagecreatetruecolor($width, $height);
    for ($y = 0; $y < $height; $y++) {
      for ($x = 0; $x < $width; $x++) {
        [$r, $g, $b] = $pixels[$y][$x];
        imagesetpixel($image, $x, $y, imagecolorallocate($image, $r, $g, $b));
      }
    }

    return $image;
  }
}
