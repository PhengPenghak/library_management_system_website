<?php

namespace app\components;

use app\models\ChoiceGroup;
use app\models\Product;
use app\models\UserVendor;
use app\models\Vendor;
use app\modules\admin\models\ContactTourItinerary;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Master extends \yii\web\Request
{

  public function isVendorOnline()
  {
    $vendor = Vendor::findOne($this->getVendorID());
    if ($vendor->status == 1) {
      return true;
    } else {
      return false;
    }
  }

  public function arrayFilterByColumn($array, $column, $value)
  {
    return array_filter($array, function ($var) use ($column, $value) {
      return ($var[$column] == $value);
    });
  }

  public function getVendorID()
  {
    if (Yii::$app->getRequest()->getCookies()->has('vendor')) {
      return Yii::$app->getRequest()->getCookies()->getValue('vendor');
    }
    return 1;
  }

  public function findChoiceGroup()
  {
    $model = ChoiceGroup::find()
      ->where(['vendor_id' => $this->getVendorID()])
      ->orderBy(['sort' => SORT_ASC])
      ->all();
    return $model;
  }

  public function findSelectedChoiceGroup($product_id)
  {
    $vendor_id = $this->getVendorID();
    $data = Yii::$app->db->createCommand(
      "SELECT 
                  choice_group.id,
                  product_choice_group.id as selected,
                  choice_group.name,
                  GROUP_CONCAT(choice_item.name SEPARATOR ', ') choice_item
              FROM choice_group
              INNER JOIN choice_item ON choice_group.id = choice_item.group_id
              LEFT JOIN product_choice_group ON choice_group.id = product_choice_group.group_id 
                  AND product_choice_group.product_id = :product_id
              WHERE choice_group.vendor_id = :vendor_id
              GROUP BY choice_item.group_id
              ORDER BY choice_group.sort"
    )
      ->bindParam(":vendor_id", $vendor_id)
      ->bindParam(":product_id", $product_id)
      ->queryAll();
    return $data;
  }

  public $options = 0, $cryption_key = "<4Te]+SM3tQ'MxfKSA/96(,a+[T#3gh", $cryption_iv = '1234567891011121', $ciphering = "AES-192-CBC";
  //"AES-128-CBC", "AES-128-CTR";

  public function lock($text)
  {
    $encryption = openssl_encrypt($text, $this->ciphering, $this->cryption_key, $this->options, $this->cryption_iv);
    return bin2hex($encryption);
    // return Yii::$app->security->hashData( $text, $this->cryption_key );
  }

  public function unlock($encryption)
  {
    $encryption = hex2bin($encryption);
    $decryption = openssl_decrypt($encryption, $this->ciphering, $this->cryption_key, $this->options, $this->cryption_iv);
    return $decryption;
    // return Yii::$app->security->validateData( $encryption, $this->cryption_key );

  }

  public function generateInvoiceNo($tbl, $prefix = "INV")
  {

    $date = date('ym');

    $db_name = explode('=', Yii::$app->db->dsn)[2];

    $created_date = Yii::$app->db->createCommand("SELECT created_date from `$tbl` order by created_date desc limit 1")->queryScalar();

    if ($created_date == "") {
      $id = 1;
      return $prefix . $date . str_pad($id, 4, '0', STR_PAD_LEFT);
    } else {
      $last_date = date_create($created_date);
      $format_date = date_format($last_date, 'ym');

      if ($format_date != $date) {
        $id = 1;
        return $prefix . $date . str_pad($id, 4, '0', STR_PAD_LEFT);
      } else {
        $id = Yii::$app->db->createCommand('SELECT AUTO_INCREMENT as id
                                FROM information_schema.TABLES
                                WHERE TABLE_SCHEMA = "' . $db_name . '"
                                AND TABLE_NAME = "' . $tbl . '"')->queryScalar();

        return $prefix . $date . str_pad($id, 4, '0', STR_PAD_LEFT);
      }
    }
  }

  public function generate_code($input)
  {
    return str_pad($input, 6, "0", STR_PAD_LEFT);
  }

  public function errToString($modelError)
  {
    return implode("<br />", \yii\helpers\ArrayHelper::getColumn($modelError, 0, false));
  }

  public function getTableTemplate()
  {
    $product = Product::find()
      ->where(['vendor_id' => $this->vendorID])
      ->andWhere(['type_id' => 1])
      ->andWhere(['food_category_id' => NULL])
      ->all();
    $base_url = Yii::getAlias("@web");
    if (!empty($product)) {
      $string = '';
      foreach ($product as $key => $value) {
        $image_url = empty($value->thumb) ? $base_url . substr('/web/img/logo-placeholder.png', 4) :  Yii::$app->awssdk->getImageUrl($value->thumb->path, 480, 480);
        $item_id = strtolower(preg_replace('~[\\\\/:*?"<>|\s+]~', "_", $value->name) . $key);
        $danger = $value->status == 0 ? 'danger' : 'info';
        $status = $value->status == 0 ? '' : 'checked';
        $disabled = $value->status == 0 ? 'disabled' : '';
        $string .= "<div class='col-12 col-md-6 p-2 mb-2'>
                                <div class='callout p-3 border $disabled callout-" . $danger . "'>
                                    <div class='float-right'>
                                        <img src='" . $image_url . "' width='75px' />
                                    </div>
                                    <h5 class='modalButton' data-toggle='tooltip' data-title=\"Update Item: $value->name\" value=\"" . Url::toRoute(['menu/update-table', 'id' => $value->id]) . "\">" . $value->name . "</h5>
                                    <p class='text-xs text-muted text-overflow-2x'>" . $value->description . "</p>
                                    <div class=\"clearfix\"></div>
                                    <hr>
                                    <div class=\"row\">
                                        " . $value->getVariationTemp() . "
                                    </div>
                                    <label class=\"switcher-control float-right switcher-control-warning switcher-control-lg\">
                                        <input type=\"checkbox\" $status data-id=\"$value->id\"  class=\"switcher-input item_status\" id=\"customSwitch$item_id\"> 
                                        <span class=\"switcher-indicator\"></span> 
                                        <span class=\"switcher-label-on\"><i class=\"fas fa-check\"></i></span> 
                                        <span class=\"switcher-label-off\"><i class=\"fas fa-times\"></i></span>
                                    </label>
                                    <div class=\"clearfix\"></div>
                                </div>
                            </div>";
      }
      return $string;
    }
  }

  public function getPackageTemplate()
  {
    $product = Product::find()
      ->where(['vendor_id' => $this->vendorID])
      ->andWhere(['type_id' => 3])
      ->andWhere(['food_category_id' => NULL])
      ->all();
    $base_url = Yii::getAlias("@web");
    if (!empty($product)) {
      $string = '';
      foreach ($product as $key => $value) {
        $image_url = empty($value->thumb) ? $base_url . substr('/web/img/logo-placeholder.png', 4) :  Yii::$app->awssdk->getImageUrl($value->thumb->path, 480, 480);
        $item_id = strtolower(preg_replace('~[\\\\/:*?"<>|\s+]~', "_", $value->name) . $key);
        $danger = $value->status == 0 ? 'danger' : 'info';
        $status = $value->status == 0 ? '' : 'checked';
        $disabled = $value->status == 0 ? 'disabled' : '';
        $string .= "<div class='col-12 col-md-6 p-2 mb-2'>
                                <div class='callout p-3 border $disabled callout-" . $danger . "'>
                                    <div class='float-right'>
                                        <img src='" . $image_url . "' width='75px' />
                                    </div>
                                    <h5 class='modalButton' data-toggle='tooltip' data-title=\"Update Item: $value->name\" value=\"" . Url::toRoute(['menu/update-package', 'id' => $value->id]) . "\">" . $value->name . "</h5>
                                    <p class='text-xs text-muted text-overflow-2x'>" . $value->description . "</p>
                                    <div class=\"clearfix\"></div>
                                    <hr>
                                    <div class=\"row\">
                                        " . $value->getVariationTemp() . "
                                    </div>
                                    <label class=\"switcher-control float-right switcher-control-warning switcher-control-lg\">
                                        <input type=\"checkbox\" $status data-id=\"$value->id\"  class=\"switcher-input item_status\" id=\"customSwitch$item_id\"> 
                                        <span class=\"switcher-indicator\"></span> 
                                        <span class=\"switcher-label-on\"><i class=\"fas fa-check\"></i></span> 
                                        <span class=\"switcher-label-off\"><i class=\"fas fa-times\"></i></span>
                                    </label>
                                    <div class=\"clearfix\"></div>
                                </div>
                            </div>";
      }
      return $string;
    }
  }
}
