<?php

namespace app\components;

use DateTime;
use Yii;

class Setupdata extends \yii\web\Request
{

  public function dayList()
  {
    return [
      ['name' => 'Monday', 'short_name' => 'Mon'],
      ['name' => 'Tuesday', 'short_name' => 'Tue'],
      ['name' => 'Wednesday', 'short_name' => 'Wed'],
      ['name' => 'Thursday', 'short_name' => 'Thu'],
      ['name' => 'Friday', 'short_name' => 'Fri'],
      ['name' => 'Saturday', 'short_name' => 'Sat'],
      ['name' => 'Sunday', 'short_name' => 'Sun'],
    ];
  }

  public function gender()
  {
    return [
      ['id' => 1, 'name' => 'Male'],
      ['id' => 2, 'name' => 'Female'],
    ];
  }

  public function pageSize()
  {
    return 20;
  }

  public function prefix()
  {
    return [
      ['id' => 1, 'name' => 'Mr.'],
      ['id' => 2, 'name' => 'Ms.'],
      ['id' => 3, 'name' => 'Mrs.'],
      ['id' => 4, 'name' => 'Dr.'],
      ['id' => 5, 'name' => 'Prof.'],
    ];
  }

  public function guestList()
  {
    return [
      ['id' => 1, 'name' => 'Adult'],
      ['id' => 2, 'name' => 'Child'],
      ['id' => 3, 'name' => 'Infant'],
    ];
  }
}
