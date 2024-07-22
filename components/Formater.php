<?php

namespace app\components;

use DateTime;
use Yii;

class Formater extends \yii\web\Request
{

  public function float($value, $decimal = 2)
  {
    return number_format($value, $decimal, '.', ',');
  }

  public function time($value, $format = "h:i:s a")
  {
    if (!empty($value)) {
      return date($format, strtotime($value));
    } else {
      return '';
    }
  }

  public function date($value, $format = "d M Y")
  {
    return date($format, strtotime($value));
  }

  public function dateRange($fromDate, $toDate)
  {
    return $this->date($fromDate) . ' - ' . $this->date($toDate);
  }

  public function dateTime($value, $format = "M d, Y h:i:s a")
  {
    return date($format, strtotime($value));
  }

  public function shortNumber($num)
  {
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
      $num /= 1000;
    }
    return round($num, 1) . $units[$i];
  }

  public function DollarFormat($number, $decimal = 2)
  {
    // if( $number - floor($number) >= 0.01  ) {
    //     $decimal = 2;
    // }else{
    //     $decimal = 0;
    // }
    return "$ " . number_format($number, $decimal, '.', ',');
  }

  public function maskNumberKH($number)
  {
    $str = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    $rplc = ['១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '០'];

    return str_replace($str, $rplc, $number);
  }

  public function maskDayKH($day)
  {
    $str = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $rplc = ['ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍', 'អាទិត្យ'];

    return str_replace($str, $rplc, $day);
  }

  public function maskLongDay($day)
  {
    $str = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $rplc = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    return str_replace($str, $rplc, $day);
  }

  public function maskMonthKH($month)
  {
    $str = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $rplc = ['មករា', 'កុម្ភះ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];

    return str_replace($str, $rplc, $month);
  }
  public function maskMonthKHmer($month)
  {
    $str = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $rplc = ['មករា', 'កុម្ភះ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];

    return str_replace($str, $rplc, $month);
  }
  public function maskDateKH($date, $format = "ថ្ងៃD, d M Y")
  {
    $str = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $rplc = ['១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '០', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍', 'អាទិត្យ', 'មករា', 'កុម្ភះ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];

    $date = date($format, strtotime($date));
    return str_replace($str, $rplc, $date);
  }

  public function maskDateTimeKH($date, $format = "ថ្ងៃD, d M Y ម៉ោង H:i:s")
  {
    $str = ['AM', 'PM', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $rplc = ['ព្រឹក', 'ល្ងាច', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '០', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍', 'អាទិត្យ', 'មករា', 'កុម្ភះ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];

    $date = date($format, strtotime($date));
    return str_replace($str, $rplc, $date);
  }

  public function maskTimeKH($hour, $format = "វេលាម៉ោង H:i:s")
  {
    $str = ['AM', 'PM', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    $rplc = ['ព្រឹក', 'ល្ងាច', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '០'];
    $hour = date($format, strtotime($hour));

    return str_replace($str, $rplc, $hour);
  }

  public function stripLength($string, $length = 250)
  {
    if (strlen($string) > $length) $string = substr($string, 0, $length - 3) . '...';
    return $string;
  }

  public function stripLengthProduct($string)
  {
    if (strlen($string) > 180) $string = substr($string, 0, 177) . '...';
    return $string;
  }

  public function stripLengthBlog($string)
  {
    if (strlen($string) > 1000) $string = substr($string, 0, 997) . '...';
    return $string;
  }

  public function calculateProgress($current, $all)
  {
    $result = ($current / max($all, 1)) * 100;
    return number_format($result, 2);
  }

  public function starRating($number = 1)
  {
    $percentage = $number * 20;
    return '<label class="star-ratings-css">
                    <label class="star-ratings-css-top" style="width: ' . $percentage . '%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></label>
                    <label class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></label>
                </label>';
  }

  public function starRatingReview($number = 1)
  {
    $outputString = '';
    for ($i = 0; $i < 5; $i++) {
      if ($i < $number) {
        $outputString .= "<i class='demo-psi-star text-warning'></i>\n";
      } else {
        $outputString .= "<i class='demo-psi-star'></i>\n";
      }
    }
    return $outputString;
  }


  public function timeAgo($datetime)
  {
    if (empty($datetime)) return '';
    $time_difference = time() - strtotime($datetime);

    if ($time_difference < 1) {
      return 'less than 1 second ago';
    }
    $condition = array(
      12 * 30 * 24 * 60 * 60  =>  'year',
      30 * 24 * 60 * 60       =>  'month',
      7 * 24 * 60 * 60        =>  'week',
      24 * 60 * 60            =>  'day',
      60 * 60                 =>  'hour',
      60                      =>  'minute',
      1                       =>  'second'
    );

    foreach ($condition as $secs => $str) {
      $d = $time_difference / $secs;

      if ($d >= 1) {
        $t = round($d);
        return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
      }
    }
  }
  public function timeAgoKH($datetime)
  {
    $time_difference = time() - strtotime($datetime);

    if ($time_difference < 1) {
      return 'less than 1 second ago';
    }
    $condition = array(
      12 * 30 * 24 * 60 * 60  =>  'ឆ្នាំ',
      30 * 24 * 60 * 60       =>  'ខែ',
      7 * 24 * 60 * 60        =>  'សប្តាហ៍',
      24 * 60 * 60            =>  'ថ្ងៃ',
      60 * 60                 =>  'ម៉ោង',
      60                      =>  'នាទី',
      1                       =>  'វិនាទី'
    );

    foreach ($condition as $secs => $str) {
      $d = $time_difference / $secs;

      if ($d >= 1) {
        $t = round($d);
        return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' មុន';
      }
    }
  }

  public function checkDiffDay($date)
  {
    $date1 = date_create($date);
    $date2 = date_create(date("Y-m-d"));
    $diff = date_diff($date1, $date2);
    return $diff->format("%a");
  }

  public function gettingDateType($date_type = 'today', $lang = 'kh')
  {
    switch ($date_type) {
      case 'yesterday':
        $from_date = date('Y-m-d', strtotime('-1 days'));
        $to_date = date('Y-m-d', strtotime('-1 days'));
        $date_string = Yii::$app->formater->maskDateKH(date("Y-m-d"), $format = "ថ្ងៃD, d M");
        if ($lang == 'en') {
          $date_string = Yii::$app->formater->date(date("Y-m-d"));
        }
        break;

      case 'today':
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $date_string = Yii::$app->formater->maskDateKH(date("Y-m-d"), $format = "ថ្ងៃD, d M");
        if ($lang == 'en') {
          $date_string = Yii::$app->formater->date(date("Y-m-d"));
        }
        break;

      case 'week':
        $from_date = date('Y-m-d', strtotime('monday this week'));
        $to_date = date('Y-m-d', strtotime('sunday this week'));
        $date_string = Yii::$app->formater->maskDateKH($from_date, $format = "ថ្ងៃD, d M") . " ដល់ " . Yii::$app->formater->maskDateKH($to_date, $format = "ថ្ងៃD, d M");
        if ($lang == 'en') {
          $date_string = Yii::$app->formater->date($from_date) . " to " . Yii::$app->formater->date($to_date);
        }
        break;

      case 'month':
        $from_date = date('Y-m-01');
        $to_date = date("Y-m-t");
        $date_string = Yii::$app->formater->maskDateKH($from_date, $format = "ថ្ងៃD, d M") . " ដល់ " . Yii::$app->formater->maskDateKH($to_date, $format = "ថ្ងៃD, d M");
        if ($lang == 'en') {
          $date_string = Yii::$app->formater->date($from_date) . " to " . Yii::$app->formater->date($to_date);
        }
        break;

      case 'year':
        $from_date = date('Y-m-d', strtotime('01/01'));
        $to_date = date('Y-m-d', strtotime('12/31'));
        $date_string = Yii::$app->formater->maskDateKH($from_date, $format = "ថ្ងៃD, d M") . " ដល់ " . Yii::$app->formater->maskDateKH($to_date, $format = "ថ្ងៃD, d M");
        if ($lang == 'en') {
          $date_string = Yii::$app->formater->date($from_date) . " to " . Yii::$app->formater->date($to_date);
        }
        break;
    }
    return ['from_date' => $from_date, 'to_date' => $to_date, 'date_string' => $date_string];
  }

  public function labelIcon($label)
  {
    $label = strtolower($label);
    switch ($label) {
      case 'home':
        return 'bi bi-house-door';
        break;
      case 'work':
        return 'bi bi-briefcase';
        break;
      case 'couple':
        return 'bi bi-suit-heart';
        break;
      case 'other':
        return 'bi bi-geo-alt';
        break;
      default:
        return 'bi bi-geo-alt';
        break;
    }
  }

  public function slugify($text, string $divider = '-')
  {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }


  public function errToString($modelError)
  {
    return implode("<br />", \yii\helpers\ArrayHelper::getColumn($modelError, 0, false));
  }

  public function phoneNumber($string)
  {
    $string = str_replace(' ', '', $string);
    $strLengh = strlen($string);
    switch ($strLengh) {
      case 9:
        return chunk_split($string, 3, ' ');
        break;
      case 10:
        return substr($string, 0, 3) . " " . chunk_split(substr($string, 3), 4, ' ');
        break;
      default:
        return $string;
        break;
    }
  }

  public function avatarName($string)
  {
    $words = preg_split("/[\s,_-]+/", ucwords($string));
    $name = '';
    foreach ($words as $w) {
      $name .= mb_substr($w, 0, 1);
    }
    return substr($name, 0, 2);
  }
}
