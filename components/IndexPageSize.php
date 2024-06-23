<?php

namespace app\components;

use Yii;
use yii\web\Cookie;

/**
 * 
 */
class IndexPageSize
{
  public static function get($total_items)
  {
    $current_page = Yii::$app->controller->id . "-index";
    Yii::$app->view->params['current_page'] = $current_page;

    $page_size = array_values(Yii::$app->params['page_size'])[0];
    $page_size_cookie = $current_page . '_page_size';
    if (isset($_REQUEST["page_size"])) {
      if (intval($_REQUEST["page_size"]) > 0) {
        $page_size = intval($_REQUEST["page_size"]);
        $set_cookies = Yii::$app->response->cookies;
        $set_cookies->add(new Cookie([
          'name' => $page_size_cookie,
          'value' => $page_size,
          'expire' => time() + (86400 * 3),
        ]));
      }
    } else {
      $get_cookies = Yii::$app->request->cookies;
      if ($get_cookies->has($page_size_cookie)) {
        $page_size = $get_cookies->getValue($page_size_cookie);
      }
    }

    $page = 0;
    $page_cookie = $current_page . '_page';
    if (isset($_REQUEST["page"])) {
      if (intval($_REQUEST["page"]) > 0) {
        $page = intval($_REQUEST["page"]) - 1;
        $set_cookies = Yii::$app->response->cookies;
        $set_cookies->add(new Cookie([
          'name' => $page_cookie,
          'value' => $page,
          'expire' => time() + (86400 * 3),
        ]));
      }
    } else {
      $get_cookies = Yii::$app->request->cookies;
      if ($get_cookies->has($page_cookie)) {
        $page = $get_cookies->getValue($page_cookie);
      }
    }
    $max_page = ceil($total_items / $page_size);

    $decrease_page = 0;
    while ($page + 1 > $max_page) {
      $page = $page - 1;
      $decrease_page = 1;
    }
    if ($decrease_page == 1) {
      $set_cookies = Yii::$app->response->cookies;
      $set_cookies->add(new Cookie([
        'name' => $page_cookie,
        'value' => $page,
        'expire' => time() + (86400 * 3),
      ]));
    }

    return [$page_size, $page];
  }
}
