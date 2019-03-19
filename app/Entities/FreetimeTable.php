<?php
  
  namespace App\Entities;

  use Carbon\Carbon;

  class FreetimeTable
  {
    public static function GetNewTable()
    {
      $template = '{"date1":"CURRENT_DATE","hours1":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date2":"CURRENT_DATE","hours2":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date3":"CURRENT_DATE","hours3":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date4":"CURRENT_DATE","hours4":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date5":"CURRENT_DATE","hours5":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free": 0,"appointment": 0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date6":"CURRENT_DATE","hours6":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}},"date7":"CURRENT_DATE","hours7":{"09:30-10:30":{"free":0,"appointment":0},"10:30-11:30":{"free":0,"appointment":0},"11:30-12:30":{"free":0,"appointment":0},"12:30-13:30":{"free":0,"appointment":0},"13:30-14:30":{"free":0,"appointment":0},"14:30-15:30":{"free":0,"appointment":0},"15:30-16:30":{"free":0,"appointment":0},"16:30-17:30":{"free":0,"appointment":0},"17:30-18:30":{"free":0,"appointment":0},"after-18:30":{"free":0,"appointment":0}}}';
      
      $new_table = json_decode($template, true);

      $current_date = new CurrentDate();
      $current_date->GetCurrentDateString();

      $new_table['date1'] = $current_date->date1;
      $new_table['date2'] = $current_date->date2;
      $new_table['date3'] = $current_date->date3;
      $new_table['date4'] = $current_date->date4;
      $new_table['date5'] = $current_date->date5;
      $new_table['date6'] = $current_date->date6;
      $new_table['date7'] = $current_date->date7;

      return json_encode($new_table);
    }

    public static function DecodeTable($json)
    {
      return json_decode($json, true);
    }

    public static function EncodeTable($json_arr)
    {
      return json_encode($json_arr);
    }

    public static function UpdateTableDates($json_arr)
    {
      $current_date = new CurrentDate();
      $current_date->GetCurrentDateString();

      $json_arr['date1'] = $current_date->date1;
      $json_arr['date2'] = $current_date->date2;
      $json_arr['date3'] = $current_date->date3;
      $json_arr['date4'] = $current_date->date4;
      $json_arr['date5'] = $current_date->date5;
      $json_arr['date6'] = $current_date->date6;
      $json_arr['date7'] = $current_date->date7;

      return $json_arr;
    }

    public static function EditTable($json_arr, $label1, $label2, $label3, $value)
    {
      $json_arr[$label1][$label2][$label3] = $value;

      return $json_arr;
    }
  }


















































