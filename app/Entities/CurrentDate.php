<?php
  
  namespace App\Entities;

  use Carbon\Carbon;

  class CurrentDate
  {
    public $date1;
    public $date2;
    public $date3;
    public $date4;
    public $date5;
    public $date6;
    public $date7;

    public function GetCurrentDateString()
    {
      $current_date = Carbon::now('Asia/Istanbul');
      $current_date = $current_date->subDays($current_date->dayOfWeek - 1);

      $this->date1 = $current_date->toDateString();
      $this->date2 = $current_date->addDay()->toDateString();
      $this->date3 = $current_date->addDay()->toDateString();
      $this->date4 = $current_date->addDay()->toDateString();
      $this->date5 = $current_date->addDay()->toDateString();
      $this->date6 = $current_date->addDay()->toDateString();
      $this->date7 = $current_date->addDay()->toDateString();
    }

    public static function GetFirstDayCurrentDate()
    {
      $current_date = Carbon::now('Asia/Istanbul');
      $current_date = $current_date->subDays($current_date->dayOfWeek - 1);

      return $current_date;
    }

    public static function GetCurrentDate()
    {
      $current_date = Carbon::now('Asia/Istanbul');

      return $current_date;
    }
  }

















































