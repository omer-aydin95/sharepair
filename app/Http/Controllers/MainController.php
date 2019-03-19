<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Session\SessionBagProxy;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Mail\ActivationMail;
use App\Mail\ResetMail;
use App\Entities\Department;
use App\Entities\User;
use App\Entities\FreetimeTable;
use App\Entities\CurrentDate;
use App\Entities\Message;
use App\Entities\Place;
use App\Entities\Appointment;
use App\Entities\Announcement;

class MainController extends Controller
{
  // Get

  public function GetIndex(Request $r)
  {
    try
    {
      if($r->session()->exists('user'))
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));
      }
      
      return view('index')->with('title', 'SharePair - Home');
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }

  public function GetAbout(Request $r)
  {
    try
    {
      if($r->session()->exists('user'))
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));
      }
      
      return view('about')->with('title', 'SharePair - About');
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }

  public function GetContact(Request $r)
  {
    try
    {
      if($r->session()->exists('user'))
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        return view('contact')->with('title', 'SharePair - Contact')->with('user_email', $r->session()->get('user')->GetSchoolEmail())->with('user_name', $r->session()->get('user')->GetName())->with('user_surname', $r->session()->get('user')->GetSurname());
      }
      else
        return view('contact')->with('title', 'SharePair - Contact');
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }

  public function GetSettings(Request $r)
  {
    if($r->session()->exists('user'))
    {
      $deps = array();

      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $res = DB::select('select * from departments');

        if(count($res) > 0)
        {
          for($i = 0; $i < count($res); $i++)
          {
            $dep = new Department();
            $dep->SetID($res[$i]->id);
            $dep->SetName($res[$i]->name);
            array_push($deps, $dep);
          }

          return view('settings')->with('deps', $deps)->with('title', 'SharePair - Settings');
        }

        return view('settings')->with('title', 'SharePair - Settings');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetLogin(Request $r)
  {
    if($r->session()->exists('user'))
      return redirect('profile');
    else
      return view('login')->with('title', 'SharePair - Login');
  }

  public function GetProfile(Request $r)
  {
    try
    {
      if($r->session()->exists('user'))
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        return view('profile')->with('title', 'SharePair - Profile');
      }
      else
        return redirect('login');
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }

  public function GetLogout(Request $r)
  {
    $r->session()->forget('user');
    $r->session()->forget('table');
    $r->session()->forget('unreaded_mes');
    $r->session()->forget('unreaded_app');

    return redirect('index');
  }

  public function GetRenew(Request $r)
  {
    if($r->session()->exists('user'))
      return redirect('profile');
    else
    {
      $reset_hash = Input::get('reset');
      
      if(isset($reset_hash))
        $reset_hash = explode('|', $reset_hash);
      else
        return redirect('index');

      try
      {
        $res = DB::select('select * from users where passwrd = ?', [$reset_hash[1]]);

        if(count($res) > 0)
        {
          for($i = 0; $i < count($res); $i++)
          {
            $hash_email = hash('sha256', $res[$i]->school_email);

            if($hash_email == $reset_hash[0])
              return view('renew')->with('title', 'SharePair - Renew');
          }

          return redirect('index');
        }
        else
          return redirect('index');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
  }

  public function GetActivation(Request $r)
  {
    if($r->session()->exists('user'))
      return redirect('profile');
    else
    {
      $activation_hash = Input::get('activate');

      if(isset($activation_hash))
        $activation_hash = explode('|', $activation_hash);
      else
        return redirect('index');

      $message = '';
      $link = '';
      $button = '';

      try
      {
        $res = DB::select('select * from users where passwrd = ?', [$activation_hash[1]]);

        if(count($res) > 0)
        {
          for($i = 0; $i < count($res); $i++)
          {
            $hash_email = hash('sha256', $res[$i]->school_email);

            if($hash_email == $activation_hash[0])
            {
              if((int)$res[0]->activated == 1)
              {
                $message = 'Account already activated. You can login to SharePair.';
                $link = 'login';
                $button = 'Login';

                break;
              }
              else
              {
                DB::update('update users set activated = 1 where school_email = ?', [$res[$i]->school_email]);

                $message = 'Account activated successfully. You can login to SharePair.';
                $link = 'login';
                $button = 'Login';

                break;
              }
            }
          }
        }
        else
        {
          $message = 'Account not found. You can register to SharePair.';
          $link = 'register';
          $button = 'Register';
        }

        return view('activation')->with('message', $message)->with('link', $link)->with('button', $button)->with('title', 'SharePair - Activation');
      }
      catch (Exception $e)
      {
        $message = 'We are so sorry. Something went wrong! Please inform us.';
        $link = 'contact';
        $button = 'Leave a Message';

        return view('activation')->with('message', $message)->with('link', $link)->with('button', $button)->with('title', 'SharePair - Activation');
      }
    }
  }

  public function GetRegister(Request $r)
  {
    if($r->session()->exists('user'))
      return redirect('profile');
    else
    {
      $deps = array();

      try
      {
        $res = DB::select('select * from departments');

        if(count($res) > 0)
        {
          for($i = 0; $i < count($res); $i++)
          {
            $dep = new Department();
            $dep->SetID($res[$i]->id);
            $dep->SetName($res[$i]->name);
            array_push($deps, $dep);
          }

          return view('register')->with('deps', $deps)->with('title', 'SharePair - Register');
        }

        return view('register')->with('title', 'SharePair - Register');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
  }

  public function GetReset(Request $r)
  {
    if($r->session()->exists('user'))
      return redirect('profile');
    else
      return view('reset')->with('title', 'SharePair - Reset');
  }

  public function GetMessages(Request $r)
  {
    if($r->session()->exists('user'))
    {
      $mess = array();
      $users = array();
      $page = 0;
      $total = 0;
      $sort = 'd_desc';

      if(Input::get('page') !== null)
        $page = (int)Input::get('page') - 1;

      if(Input::get('sort') !== null)
        $sort = Input::get('sort');

      try
      {
        DB::update('update messages set readed = 1 where owner_user = ?', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', 0);

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $res = DB::select('select count(*) as total from messages where owner_user = ?', [$r->session()->get('user')->GetID()]);

        $total = (int)$res[0]->total;

        if($sort == 'd_desc')
        {
          $res = DB::select('select messages.id as mid, owner_user, from_user, content, readed, mdate, users.id as uid, name, surname from messages, users where owner_user = ? and from_user = users.id order by mdate desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
        }
        else if($sort == 'd_asc')
        {
          $res = DB::select('select messages.id as mid, owner_user, from_user, content, readed, mdate, users.id as uid, name, surname from messages, users where owner_user = ? and from_user = users.id order by mdate asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
        }
        else if($sort == 'f_desc')
        {
          $res = DB::select('select messages.id as mid, owner_user, from_user, content, readed, mdate, users.id as uid, name, surname from messages, users where owner_user = ? and from_user = users.id order by from_user desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
        }
        else if($sort == 'f_asc')
        {
          $res = DB::select('select messages.id as mid, owner_user, from_user, content, readed, mdate, users.id as uid, name, surname from messages, users where owner_user = ? and from_user = users.id order by from_user asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
        }

        if(count($res) > 0)
        {
          for($i = 0; $i < count($res); $i++)
          {
            $mes = new Message();
            $mes->SetID($res[$i]->mid);
            $mes->SetOwnerUser($res[$i]->owner_user);
            $mes->SetFromUser($res[$i]->from_user);
            $mes->SetContent($res[$i]->content);
            $mes->SetReaded((int)$res[$i]->readed);
            $mes->SetDate($res[$i]->mdate);
            array_push($mess, $mes);

            $user = new User();
            $user->SetID($res[$i]->uid);
            $user->SetName($res[$i]->name);
            $user->SetSurname($res[$i]->surname);
            array_push($users, $user);
          }

          return view('messages')->with('mess', $mess)->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Messages');
        }

        return view('messages')->with('mess', $mess)->with('total', 0)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', 0)->with('title', 'SharePair - Messages');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetSendM(Request $r)
  {
    if($r->session()->exists('user'))
    {
      $user_id = Input::get('id');

      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        if(isset($user_id))
        {
          $user_id = (int)$user_id;

          $res = DB::select('select * from users where id = ?', [$user_id]);

          if(count($res) > 0)
          {
            $user = new User();
            $user->SetID($user_id);
            $user->SetName($res[0]->name);
            $user->SetSurname($res[0]->surname);

            return view('send-m')->with('user', $user)->with('title', 'SharePair - Send Message');
          }
          else
            return redirect('profile');
        }
        else
          return redirect('profile');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetSendR(Request $r)
  {
    if($r->session()->exists('user'))
    {
      $user_id = Input::get('id');

      try
      {
        if(isset($user_id))
        {
          $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
          $r->session()->put('unreaded_mes', count($res));

          $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
          $r->session()->put('unreaded_app', count($res));

          $user_id = (int)$user_id;

          $res = DB::select('select * from users where id = ?', [$user_id]);

          if(count($res) > 0)
          {
            $user = new User();
            $user->SetID($user_id);
            $user->SetName($res[0]->name);
            $user->SetSurname($res[0]->surname);
            $user->SetTable($res[0]->freetime_json);

            $table = FreetimeTable::DecodeTable($res[0]->freetime_json);
            $table = FreetimeTable::UpdateTableDates($table);

            $available_dates = array();
            $places = array();

            for($i = 0; $i < 7; $i++)
            {
              $date_key = 'date' . strval($i + 1);
              $hours_key = 'hours' . strval($i + 1);

              if($table[$hours_key]['09:30-10:30']['free'] == 1 &&
                 $table[$hours_key]['09:30-10:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 09:30 - 10:30');

              if($table[$hours_key]['10:30-11:30']['free'] == 1 &&
                 $table[$hours_key]['10:30-11:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 10:30 - 11:30');

              if($table[$hours_key]['11:30-12:30']['free'] == 1 &&
                 $table[$hours_key]['11:30-12:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 11:30 - 12:30');

              if($table[$hours_key]['12:30-13:30']['free'] == 1 &&
                 $table[$hours_key]['12:30-13:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 12:30 - 13:30');

              if($table[$hours_key]['13:30-14:30']['free'] == 1 &&
                 $table[$hours_key]['13:30-14:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 13:30 - 14:30');

              if($table[$hours_key]['14:30-15:30']['free'] == 1 &&
                 $table[$hours_key]['14:30-15:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 14:30 - 15:30');

              if($table[$hours_key]['15:30-16:30']['free'] == 1 &&
                 $table[$hours_key]['15:30-16:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 15:30 - 16:30');

              if($table[$hours_key]['16:30-17:30']['free'] == 1 &&
                 $table[$hours_key]['16:30-17:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 16:30 - 17:30');

              if($table[$hours_key]['17:30-18:30']['free'] == 1 &&
                 $table[$hours_key]['17:30-18:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', 17:30 - 18:30');

              if($table[$hours_key]['after-18:30']['free'] == 1 &&
                 $table[$hours_key]['after-18:30']['appointment'] == 0)
                array_push($available_dates,
                           $table[$date_key] . ', After 18:30');
            }

            $res = DB::select('select * from places');

            for($i = 0; $i < count($res); $i++)
            {
              $place = new Place($res[$i]->id, $res[$i]->name, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);

              array_push($places, $place);
            }

            return view('send-r')->with('user', $user)->with('places', $places)->with('available_dates', $available_dates)->with('title', 'SharePair - Send Request');
          }
          else
            return redirect('profile');
        }
        else
          return redirect('profile');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetCreateAnno(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $curr_dates = new CurrentDate();
        $curr_dates->GetCurrentDateString();

        $places = array();

        $res = DB::select('select * from places');

        for($i = 0; $i < count($res); $i++)
        {
          $place = new Place($res[$i]->id, $res[$i]->name, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);

          array_push($places, $place);
        }

        return view('create-announcement')->with('curr_dates', $curr_dates)->with('places', $places)->with('title', 'SharePair - Create Announcement');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetAnno(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $page = 0;
        $total = 0;
        $sort = 'o_desc';
        $show = 'all';
        $search = '';
        $annos = array();
        $users = array();
        $places = array();

        if(Input::get('page') !== null)
          $page = (int)Input::get('page') - 1;

        if(Input::get('sort') !== null)
          $sort = Input::get('sort');

        if(Input::get('show') !== null)
          $show = Input::get('show');

        if(Input::get('search') !== null)
          $search = rawurldecode(Input::get('search'));

        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        if($show == 'all')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from announcements');

            $total = (int)$res[0]->total;

            if($total > 0)
            {
              if($sort == 'o_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id order by uname desc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'o_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id order by uname asc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'a_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id order by replied asc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'a_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id order by replied desc limit 10 offset ?', [$page * 10]);
              }

              if(count($res) > 0)
              {
                for($i = 0; $i < count($res); $i++)
                {
                  $anno = new Announcement((int)$res[$i]->aid, (int)$res[$i]->owner_user, $res[$i]->content, $res[$i]->adate, (int)$res[$i]->place, (int)$res[$i]->replied);
                  array_push($annos, $anno);

                  $user = new User();
                  $user->SetID($res[$i]->uid);
                  $user->SetName($res[$i]->uname);
                  $user->SetSurname($res[$i]->surname);
                  $users[$res[$i]->uid] = $user;

                  $place = new Place($res[$i]->pid, $res[$i]->pname, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);
                  $places[$res[$i]->pid] = $place;
                }
              }
            }

            if($total > 0)
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
            else
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
          }
          else
          {
            $res = DB::select('select count(*) as total from announcements');

            $total = (int)$res[0]->total;

            if($total > 0)
            {
              if($sort == 'o_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by uname desc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'o_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by uname asc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'a_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by replied asc limit 10 offset ?', [$page * 10]);
              }
              else if($sort == 'a_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by replied desc limit 10 offset ?', [$page * 10]);
              }

              if(count($res) > 0)
              {
                for($i = 0; $i < count($res); $i++)
                {
                  $anno = new Announcement((int)$res[$i]->aid, (int)$res[$i]->owner_user, $res[$i]->content, $res[$i]->adate, (int)$res[$i]->place, (int)$res[$i]->replied);
                  array_push($annos, $anno);

                  $user = new User();
                  $user->SetID($res[$i]->uid);
                  $user->SetName($res[$i]->uname);
                  $user->SetSurname($res[$i]->surname);
                  $users[$res[$i]->uid] = $user;

                  $place = new Place($res[$i]->pid, $res[$i]->pname, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);
                  $places[$res[$i]->pid] = $place;
                }
              }
            }

            if($total > 0)
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
            else
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
          }
        }
        else if($show == 'me')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from announcements where owner_user = ?', [$r->session()->get('user')->GetID()]);

            $total = (int)$res[0]->total;

            if($total > 0)
            {
              if($sort == 'o_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? order by uname desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'o_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? order by uname asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'a_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? order by replied asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'a_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? order by replied desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }

              if(count($res) > 0)
              {
                for($i = 0; $i < count($res); $i++)
                {
                  $anno = new Announcement((int)$res[$i]->aid, (int)$res[$i]->owner_user, $res[$i]->content, $res[$i]->adate, (int)$res[$i]->place, (int)$res[$i]->replied);
                  array_push($annos, $anno);

                  $user = new User();
                  $user->SetID($res[$i]->uid);
                  $user->SetName($res[$i]->uname);
                  $user->SetSurname($res[$i]->surname);
                  $users[$res[$i]->uid] = $user;

                  $place = new Place($res[$i]->pid, $res[$i]->pname, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);
                  $places[$res[$i]->pid] = $place;
                }
              }
            }

            if($total > 0)
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
            else
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
          }
          else
          {
            $res = DB::select('select count(*) as total from announcements where owner_user = ?', [$r->session()->get('user')->GetID()]);

            $total = (int)$res[0]->total;

            if($total > 0)
            {
              if($sort == 'o_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by uname desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'o_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by uname asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'a_asc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by replied asc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }
              else if($sort == 'a_desc')
              {
                $res = DB::select('select announcements.id as aid, owner_user, content, adate, place, replied, users.id as uid, users.name as uname, surname, places.id as pid, places.name as pname, places.department, floor, max_capacity from announcements, users, places where announcements.owner_user = users.id and announcements.place = places.id and owner_user = ? and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by replied desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);
              }

              if(count($res) > 0)
              {
                for($i = 0; $i < count($res); $i++)
                {
                  $anno = new Announcement((int)$res[$i]->aid, (int)$res[$i]->owner_user, $res[$i]->content, $res[$i]->adate, (int)$res[$i]->place, (int)$res[$i]->replied);
                  array_push($annos, $anno);

                  $user = new User();
                  $user->SetID($res[$i]->uid);
                  $user->SetName($res[$i]->uname);
                  $user->SetSurname($res[$i]->surname);
                  $users[$res[$i]->uid] = $user;

                  $place = new Place($res[$i]->pid, $res[$i]->pname, $res[$i]->department, $res[$i]->floor, $res[$i]->max_capacity);
                  $places[$res[$i]->pid] = $place;
                }
              }
            }

            if($total > 0)
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
            else
              return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
          }
        }
        else
          return view('announcements')->with('annos', $annos)->with('places', $places)->with('show', $show)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('sort', $sort)->with('page', $page + 1)->with('title', 'SharePair - Announcements');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetUser(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $page = 0;
        $total = 0;

        if(Input::get('id') !== null)
          $user_id = (int)Input::get('id');

        if($r->session()->get('user')->GetID() == $user_id)
          return redirect('profile');

        if(Input::get('page') !== null)
          $page = (int)Input::get('page') - 1;

        if(!isset($user_id))
          return redirect('login');

        $res = DB::select('select * from users where id = ?', [$user_id]);

        if(count($res) > 0)
        {
          $user = new User();

          $user->SetID($user_id);
          $user->SetName($res[0]->name);
          $user->SetSurname($res[0]->surname);
          $user->SetGrade($res[0]->grade);
          $user->SetDepartment($res[0]->department);
          $user->SetAbout($res[0]->about);
          $user->SetTable($res[0]->freetime_json);
          $user->SetWillTeach($res[0]->will_teach);
          $user->SetPhoto($res[0]->photo);

          $json_arr = FreetimeTable::DecodeTable($res[0]->freetime_json);
          $json_arr = FreetimeTable::UpdateTableDates($json_arr);

          $r->session()->put('user_table', $json_arr);

          $res_app = DB::select('select adate, point, content, name, department, floor, max_capacity from appointments, places where owner_user = ? and sent_by_owner = 0 and accepted = 1 and completed = 1 and place = places.id order by appointments.id desc', [$user_id]);

          $total = count($res_app);

          $res_app = DB::select('select adate, point, content, name, department, floor, max_capacity from appointments, places where owner_user = ? and sent_by_owner = 0 and accepted = 1 and completed = 1 and place = places.id order by appointments.id desc limit 10 offset ?', [$user_id, $page * 10]);

          $apps = array();
          $places = array();

          if(count($res_app) > 0)
          {
            for($i = 0; $i < count($res_app); $i++)
            {
              $app = new Appointment();
              $app->SetDate($res_app[$i]->adate);
              $app->SetPoint($res_app[$i]->point);
              $app->SetContent($res_app[$i]->content);
              array_push($apps, $app);

              array_push($places, $res_app[$i]->name . ', ' . $res_app[$i]->department . ', ' . $res_app[$i]->floor . ', ' . strval($res_app[$i]->max_capacity));
            }
          }

          return view('user')->with('title', 'SharePair - ' . $res[0]->name . ' ' . $res[0]->surname)->with('user', $user)->with('apps', $apps)->with('places', $places)->with('page', $page + 1)->with('total', $total)->with('current_total', count($res_app))->with('user_id', $user_id);
        }
        else
          return redirect('profile');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetAppo(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $page = 0;
        $total = 0;
        $show = 'all';
        $search = '';
        $users = array();
        $apps = array();
        $places = array();

        if(Input::get('page') !== null)
          $page = (int)Input::get('page') - 1;

        if(Input:: get('show') !== null)
          $show = Input::get('show');

        if(Input::get('search') !== null)
          $search = rawurldecode(Input::get('search'));

        if($show == 'unanswered')
        {
          $res = DB::select('select count(*) as total from appointments where owner_user = ? and completed = 0 and accepted = 0 and (sent_by_owner = 1 or sent_by_owner = 0)', [$r->session()->get('user')->GetID()]);

          $total = (int)$res[0]->total;

          if($search == '')
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 0 and accepted = 0 and (sent_by_owner = 1 or sent_by_owner = 0) order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
          else
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 0 and accepted = 0 and (sent_by_owner = 1 or sent_by_owner = 0) and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
        }
        else if($show == 'accepted')
        {
          $res = DB::select('select count(*) as total from appointments where owner_user = ? and completed = 0 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0)', [$r->session()->get('user')->GetID()]);

          $total = (int)$res[0]->total;

          if($search == '')
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 0 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0) order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
          else
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 0 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0) and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
        }
        else if($show == 'completed')
        {
          $res = DB::select('select count(*) as total from appointments where owner_user = ? and completed = 1 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0)', [$r->session()->get('user')->GetID()]);

          $total = (int)$res[0]->total;

          if($search == '')
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 1 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0) order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
          else
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and completed = 1 and accepted = 1 and (sent_by_owner = 1 or sent_by_owner = 0) and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
        }
        else
        {
          $res = DB::select('select count(*) as total from appointments where owner_user = ? and (completed = 1 or completed = 0) and (accepted = 1 or completed = 0) and (sent_by_owner = 1 or sent_by_owner = 0)', [$r->session()->get('user')->GetID()]);

          $total = (int)$res[0]->total;

          if($search == '')
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and (completed = 1 or completed = 0) and (accepted = 1 or completed = 0) and (sent_by_owner = 1 or sent_by_owner = 0) order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
          else
          {
            if($total > 0)
            {
              $res = DB::select('select appointments.id as aid, adate, point, content, accepted, sent_by_owner, completed, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where with_user = users.id and place = places.id and owner_user = ? and (completed = 1 or completed = 0) and (accepted = 1 or completed = 0) and (sent_by_owner = 1 or sent_by_owner = 0) and (content like \'%' . $search . '%\' or users.name like \'%' . $search . '%\' or users.surname like \'%' . $search . '%\' or adate like \'%' . $search . '%\' or places.name like \'%' . $search . '%\' or places.department like \'%' . $search . '%\' or places.floor like \'%' . $search . '%\' or places.max_capacity like \'%' . $search . '%\') order by appointments.id desc limit 10 offset ?', [$r->session()->get('user')->GetID(), $page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $app = new Appointment();
                $app->SetID((int)$res[$i]->aid);
                $app->SetDate($res[$i]->adate);
                $app->SetPoint((int)$res[$i]->point);
                $app->SetContent($res[$i]->content);
                $app->SetAccepted((int)$res[$i]->accepted);
                $app->SetSentByOwner((int)$res[$i]->sent_by_owner);
                $app->SetCompleted((int)$res[$i]->completed);
                array_push($apps, $app);

                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->uname);
                $user->SetSurname($res[$i]->surname);
                $users[(int)$res[$i]->aid] = $user;

                $place = new Place();
                $place->SetName($res[$i]->pname);
                $place->SetDepartment($res[$i]->department);
                $place->SetFloor($res[$i]->floor);
                $place->SetMaxCapacity((int)$res[$i]->max_capacity);
                $places[(int)$res[$i]->aid] = $place;
              }

              return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', count($res));
            }

            return view('appointments')->with('title', 'SharePair - Appointments')->with('page', $page + 1)->with('show', $show)->with('search', rawurlencode($search))->with('apps', $apps)->with('users', $users)->with('places', $places)->with('total', $total)->with('current_total', 0);
          }
        }
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetCanAppo(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        if(Input::get('id') !== null)
          $appid = (int)Input::get('id');
        else
          return redirect('appointments?page=1&show=all&search=');

        $res = DB::select('select appointments.id as aid, adate, content, accepted, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where appointments.id = ?', [$appid]);

        $app = new Appointment();
        $user = new User();
        $place = new Place();
        $emp = 0;

        if(count($res) > 0)
        {
          $app->SetID((int)$res[0]->aid);
          $app->SetDate($res[0]->adate);
          $app->SetContent($res[0]->content);
          $app->SetAccepted((int)$res[0]->accepted);
          
          $user->SetID((int)$res[0]->uid);
          $user->SetName($res[0]->uname);
          $user->SetSurname($res[0]->surname);
          
          $place->SetName($res[0]->pname);
          $place->SetDepartment($res[0]->department);
          $place->SetFloor($res[0]->floor);
          $place->SetMaxCapacity((int)$res[0]->max_capacity);

          if($res[0]->accepted == -2)
            $title = 'SharePair - Canceled Appointment Details';
          else if($res[0]->accepted == 1)
            $title = 'SharePair - Accepted Appointment Details';
          else
            $title = 'SharePair - Appointment Details';

          $emp = 1;
        }

        if($emp == 1)
          return view('appointment')->with('title', $title)->with('app', $app)->with('user', $user)->with('place', $place)->with('emp', $emp);
        else
          return view('appointment')->with('title', 'SharePair - Appointment Details')->with('app', $app)->with('user', $user)->with('place', $place)->with('emp', $emp);
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetRatAppo(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        if(Input::get('id') !== null)
          $appid = (int)Input::get('id');
        else
          return redirect('appointments?page=1&show=all&search=');

        $res = DB::select('select appointments.id as aid, adate, content, accepted, users.id as uid, users.name as uname, surname, places.name as pname, places.department, floor, max_capacity from appointments, users, places where appointments.id = ?', [$appid]);

        $app = new Appointment();
        $app->SetID((int)$res[0]->aid);
        $app->SetDate($res[0]->adate);
        $app->SetContent($res[0]->content);
        $app->SetAccepted((int)$res[0]->accepted);

        $user = new User();
        $user->SetID((int)$res[0]->uid);
        $user->SetName($res[0]->uname);
        $user->SetSurname($res[0]->surname);

        $place = new Place();
        $place->SetName($res[0]->pname);
        $place->SetDepartment($res[0]->department);
        $place->SetFloor($res[0]->floor);
        $place->SetMaxCapacity((int)$res[0]->max_capacity);

        return view('rate-appointment')->with('title', 'SharePair - Rate Appointment')->with('app', $app)->with('user', $user)->with('place', $place);
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  public function GetFindPair(Request $r)
  {
    if($r->session()->exists('user'))
    {
      try
      {
        $res = DB::select('select * from messages where owner_user = ? and readed = 0', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_mes', count($res));

        $res = DB::select('select * from appointments where owner_user = ? and accepted != -2 and (accepted = 0 or completed = 0)', [$r->session()->get('user')->GetID()]);
        $r->session()->put('unreaded_app', count($res));

        $page = 0;
        $total = 0;
        $sort = 'p_desc';
        $search = '';
        $users = array();
        $points = array();

        if(Input::get('page') !== null)
          $page = (int)Input::get('page') - 1;

        if(Input::get('sort') !== null)
          $sort = Input::get('sort');

        if(Input::get('search') !== null)
          $search = rawurldecode(Input::get('search'));

        if($sort == 'p_desc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by overall desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by overall desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'p_asc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by overall asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by overall asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'u_desc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by name desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by name desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'u_asc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by name asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by name asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'g_desc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by grade desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by grade desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'g_asc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by grade asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by grade asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'd_desc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by department desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by department desc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
        else if($sort == 'd_asc')
        {
          if($search == '')
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 group by users.id order by department asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
          else
          {
            $res = DB::select('select count(*) as total from users where will_teach = 1');
            $total = (int)$res[0]->total;

            if($total > 0)
            {
              $res = DB::select('select users.id as uid, name, surname, grade, department, about, SUM(point) as overall from users, appointments where will_teach = 1 and owner_user = users.id and accepted = 1 and completed = 1 and sent_by_owner = 0 and (name like \'%' . $search . '%\' or surname like \'%'. $search . '%\' or about like \'%' . $search . '%\' or grade like \'%' . $search . '%\' or department like \'%' . $search . '%\') group by users.id order by department asc limit 10 offset ?', [$page * 10]);

              for($i = 0; $i < count($res); $i++)
              {
                $user = new User();
                $user->SetID((int)$res[$i]->uid);
                $user->SetName($res[$i]->name);
                $user->SetSurname($res[$i]->surname);
                $user->SetGrade($res[$i]->grade);
                $user->SetDepartment($res[$i]->department);
                $user->SetAbout($res[$i]->about);
                array_push($users, $user);

                if((int)$res[$i]->overall % 5 == 0)
                  $points[$res[$i]->uid] = 5;
                else
                  $points[$res[$i]->uid] = (int)$res[$i]->overall % 5;
              }
            }

            if($total > 0)
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', count($res))->with('users', $users)->with('points', $points);
            else
              return view('find-pair')->with('title', 'SharePair - Find Pair')->with('page', $page + 1)->with('sort', $sort)->with('search', rawurlencode($search))->with('total', $total)->with('current_total', 0)->with('users', $users)->with('points', $points);
          }
        }
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('login');
  }

  //////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////

  // Post

  public function PostRegister(Request $r)
  {
    if(!empty($r->name) && !empty($r->surname) && !empty($r->email) &&
       !empty($r->passwrd) && !empty($r->conpasswrd))
    {
      if($r->gradecategory != 'Select your grade' && $r->depcategory != 'Select your department')
      {
        if(filter_var($r->email, FILTER_VALIDATE_EMAIL) && strpos($r->email, '.edu.tr'))
        {
          if($r->passwrd == $r->conpasswrd)
          {
            try
            {
              $res = DB::select('select * from users where school_email = ?', [$r->email]);

              if(count($res) <= 0)
              {
                $hash_pass = hash('sha256', $r->passwrd);
                $hash_email = hash('sha256', $r->email);

                $new_user = new User($r->email, $r->name, $r->surname, $hash_pass, $r->gradecategory,
                                      $r->depcategory, '/storage/avatar.png');

                if(!empty($r->file('picfile')))
                {
                  $photo_path = '/storage/' . Storage::disk('public')->putFile('', $r->file('picfile'));
                  $new_user->SetPhoto($photo_path);
                }

                $table = FreetimeTable::GetNewTable();

                DB::insert('insert into users(school_email, name, surname, passwrd, grade, department, freetime_json, photo) values(?, ?, ?, ?, ?, ?, ?, ?)', [$new_user->GetSchoolEmail(), $new_user->GetName(), $new_user->GetSurname(), $new_user->GetPasswrd(), $new_user->GetGrade(), $new_user->GetDepartment(), $table, $new_user->GetPhoto()]);

                $activation_link = 'http://www.sharepair.a2hosted.com/activation?activate=' . $hash_email . '|' . $hash_pass;

                Mail::to($new_user->GetSchoolEmail())->send(new ActivationMail($activation_link));

                return response(['title' => 'Successful!', 'content' => 'You registered successfully.<br> Please activate your account!', 'status' => 'success']);
              }
              else
                return response(['title' => 'User already exists!', 'content' => 'User already exists, you can login to SharePair.', 'status' => 'error']);
            }
            catch (Exception $e)
            {
              return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
            }
          }
          else
            return response(['title' => 'Passwords does not match!', 'content' => 'Please enter same password to the password fields.', 'status' => 'error']);
        }
        else
          return response(['title' => 'Invalid email!', 'content' => 'Please enter a valid school email.', 'status' => 'error']);
      }
      else
        return response(['title' => 'Empty fields!', 'content' => 'Please select your grade and department.', 'status' => 'error']);
    }
    else
      return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
  }

  public function PostLogin(Request $r)
  {
    if(!empty($r->email) && !empty($r->passwrd))
    {
      try
      {
        $hash_pass = hash('sha256', $r->passwrd);

        $res = DB::select('select * from users where school_email = ? and passwrd = ?', [$r->email, $hash_pass]);

        if(count($res) > 0)
        {
          if((int)$res[0]->activated == 0)
            return response(['title' => 'Inactivated account!', 'content' => 'Please activate your account before login.', 'status' => 'error']);
          else
          {
            $user = new User($res[0]->school_email, $res[0]->name, $res[0]->surname,
                              $res[0]->passwrd, $res[0]->grade, $res[0]->department,
                              $res[0]->photo, $res[0]->about, (int)$res[0]->will_teach,
                              (int)$res[0]->activated, $res[0]->created, $res[0]->freetime_json, (int)$res[0]->id);

            $r->session()->put('user', $user);

            $json_arr = FreetimeTable::DecodeTable($r->session()->get('user')->GetTable());
            $json_arr = FreetimeTable::UpdateTableDates($json_arr);

            $r->session()->put('table', $json_arr);

            return response(['title' => 'OK', 'content' => 'OK', 'status' => 'success']);
          }
        }
        else
          return response(['title' => 'Wrong credentials!', 'content' => 'School email or password is wrong.', 'status' => 'error']);
      }
      catch(Exception $e)
      {
        return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
      }
    }
    else
      return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
  }

  public function PostMessages(Request $r)
  {
    if(!empty($r->check_list) && !empty($r->del_sel))
    {
      try
      {
        foreach ($r->check_list as $check)
          DB::delete('delete from messages where id = ?', [$check]);
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }

    return redirect('messages?page=1&sort=d_desc');
  }

  public function PostProfile(Request $r)
  {
    if(!empty($r->check_list))
    {
      try
      {
        $table = FreetimeTable::GetNewTable();

        $table = FreetimeTable::DecodeTable($table);

        foreach ($r->check_list as $check)
        {
          $labels = explode('|', $check);

          $table = FreetimeTable::EditTable($table, $labels[0], $labels[1], $labels[2], 1);
        }

        $r->session()->forget('table');
        $r->session()->put('table', $table);

        $table = FreetimeTable::EncodeTable($table);

        DB::update('update users set freetime_json = ? where school_email = ?', [$table, $r->session()->get('user')->GetSchoolEmail()]);

        $r->session()->get('user')->SetTable($table);

        return response(['title' => 'Successful', 'content' => 'Your freetime table was saved successfully.', 'status' => 'success']);
      }
      catch(Exception $e)
      {
        return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
      }
    }
    else
    {
      try
      {
        $table = FreetimeTable::GetNewTable();

        $table = FreetimeTable::DecodeTable($table);

        $r->session()->forget('table');
        $r->session()->put('table', $table);

        $table = FreetimeTable::EncodeTable($table);

        DB::update('update users set freetime_json = ? where school_email = ?', [$table, $r->session()->get('user')->GetSchoolEmail()]);

        $r->session()->get('user')->SetTable($table);

        return response(['title' => 'Successful', 'content' => 'Your freetime table was saved successfully.', 'status' => 'success']);
      }
      catch(Exception $e)
      {
        return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
      }
    }
  }

  public function PostReset(Request $r)
  {
    if(!empty($r->email))
    {
      try
      {
        $res = DB::select('select * from users where school_email = ?', [$r->email]);

        if(count($res) > 0)
        {
          $hash_email = hash('sha256', $r->email);

          $reset_link = 'http://www.sharepair.a2hosted.com/renew?reset=' . $hash_email . '|' . $res[0]->passwrd;

          Mail::to($r->email)->send(new ResetMail($reset_link));

          return response(['title' => 'Successful!', 'content' => 'Please check your email to reset your password.', 'status' => 'success']);
        }
        else
          return response(['title' => 'Wrong credentials!', 'content' => 'There is no user with entered email.', 'status' => 'error']);
      }
      catch(Exception $e)
      {
        return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
      }
    }
    else
      return response(['title' => 'Empty field!', 'content' => 'Please fill email field.', 'status' => 'error']);
  }

  public function PostRenew(Request $r)
  {
    if(!empty($r->newpass) && !empty($r->connewpass))
    {
      if($r->newpass == $r->connewpass)
      {
        $reset_hash = Input::get('reset');
        $reset_hash = explode('|', $reset_hash);

        try
        {
          $res = DB::select('select * from users where passwrd = ?', [$reset_hash[1]]);

          if(count($res) > 0)
          {
            for($i = 0; $i < count($res); $i++)
            {
              $hash_email = hash('sha256', $res[$i]->school_email);

              if($hash_email == $reset_hash[0])
              {
                $hash_pass = hash('sha256', $r->newpass);

                DB::update('update users set passwrd = ? where school_email = ?', [$hash_pass, $res[$i]->school_email]);

                return response(['title' => 'Successful!', 'content' => 'You can login with your new password.', 'status' => 'success']);
              }
            }

            return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
          }
          else
            return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
        }
        catch(Exception $e)
        {
          return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
        }
      }
      else
        return response(['title' => 'Passwords does not match!', 'content' => 'Please enter same password to the fields.', 'status' => 'error']);
    }
    else
      return response(['title' => 'Empty fields!', 'content' => 'Please fill password fields.', 'status' => 'error']);
  }

  public function PostSettings(Request $r)
  {
    try
    {
      $new_settings = new User();
      $current_settings = $r->session()->get('user');

      if(!empty($r->curpasswrd) && !empty($r->newpasswrd) && !empty($r->repasswrd))
      {
        $hash_pass = hash('sha256', $r->curpasswrd);

        if($hash_pass == $current_settings->GetPasswrd() && ($r->newpasswrd == $r->repasswrd))
        {
          $hash_pass = hash('sha256', $r->newpasswrd);

          $new_settings->SetPasswrd($hash_pass);

          if($r->gradecategory != 'Select your grade' && ($r->gradecategory != $current_settings->GetGrade()))
            $new_settings->SetGrade($r->gradecategory);
          else if($r->gradecategory == 'Select your grade')
            return response(['title' => 'Empty fields!', 'content' => 'Please select your grade!', 'status' => 'error']);

          if($r->depcategory != 'Select your department' && ($r->depcategory != $current_settings->GetDepartment()))
            $new_settings->SetDepartment($r->depcategory);
          else if($r->depcategory == 'Select your department')
            return response(['title' => 'Empty fields!', 'content' => 'Please select your department!', 'status' => 'error']);

          if(!empty($r->about) && ($r->about != $current_settings->GetAbout()))
            $new_settings->SetAbout($r->about);

          if($r->teach == 'I will not teach some topics to other students')
            $new_settings->SetWillTeach(0);
          else
            $new_settings->SetWillTeach(1);

          if(!empty($r->file('picfile')))
          {
            $old_image = str_replace('/storage/', '', $current_settings->GetPhoto());
            if($old_image != 'avatar.png')
              Storage::disk('public')->delete($old_image);

            $photo_path = '/storage/' . Storage::disk('public')->putFile('', $r->file('picfile'));
            $new_settings->SetPhoto($photo_path);
          }

          $query = 'update users set';
          $query_arr = array();

          if($new_settings->GetPasswrd() != '')
          {
            $query = $query . ' passwrd = ?';
            array_push($query_arr, $new_settings->GetPasswrd());
            $current_settings->SetPasswrd($new_settings->GetPasswrd());
          }

          if($new_settings->GetGrade() != '')
          {
            $query = $query . ' grade = ?';
            array_push($query_arr, $new_settings->GetGrade());
            $current_settings->SetGrade($new_settings->GetGrade());
          }

          if($new_settings->GetDepartment() != '')
          {
            $query = $query . ' department = ?';
            array_push($query_arr, $new_settings->GetDepartment());
            $current_settings->SetDepartment($new_settings->GetDepartment());
          }

          if($new_settings->GetAbout() != '')
          {
            $query = $query . ' about = ?';
            array_push($query_arr, $new_settings->GetAbout());
            $current_settings->SetAbout($new_settings->GetAbout());
          }
          else
          {
            $query = $query . ' about = null,';
            $current_settings->SetAbout('');
          }

          $query = $query . ' will_teach = ?';
          array_push($query_arr, $new_settings->GetWillTeach());
          $current_settings->SetWillTeach($new_settings->GetWillTeach());

          if($new_settings->GetPhoto() != '')
          {
            $query = $query . ' photo = ?';
            array_push($query_arr, $new_settings->GetPhoto());
            $current_settings->SetPhoto($new_settings->GetPhoto());
          }

          $query = str_replace('? ', '?,', $query);
          $query = $query . ' where school_email = ?';
          array_push($query_arr, $current_settings->GetSchoolEmail());

          DB::update($query, $query_arr);

          $r->session()->forget('user');
          $r->session()->put('user', $current_settings);

          return response(['title' => 'Successful!', 'content' => 'New settings saved successfully.', 'status' => 'success']);
        }
        else
          return response(['title' => 'Wrong credentials!', 'content' => 'Current password is wrong or new passwords does not match.', 'status' => 'error']);
      }
      else
      {
        if($r->gradecategory != 'Select your grade' && ($r->gradecategory != $current_settings->GetGrade()))
            $new_settings->SetGrade($r->gradecategory);
        else if($r->gradecategory == 'Select your grade')
          return response(['title' => 'Empty fields!', 'content' => 'Please select your grade!', 'status' => 'error']);

        if($r->depcategory != 'Select your department' && ($r->depcategory != $current_settings->GetDepartment()))
            $new_settings->SetDepartment($r->depcategory);
        else if($r->depcategory == 'Select your department')
          return response(['title' => 'Empty fields!', 'content' => 'Please select your department!', 'status' => 'error']);

        if(!empty($r->about) && ($r->about != $current_settings->GetAbout()))
          $new_settings->SetAbout($r->about);

        if($r->teach == 'I will not teach some topics to other students')
            $new_settings->SetWillTeach(0);
        else
            $new_settings->SetWillTeach(1);

        if(!empty($r->file('picfile')))
        {
          $old_image = str_replace('/storage/', '', $current_settings->GetPhoto());
          if($old_image != 'avatar.png')
            Storage::disk('public')->delete($old_image);

          $photo_path = '/storage/' . Storage::disk('public')->putFile('', $r->file('picfile'));
          $new_settings->SetPhoto($photo_path);
        }

        $query = 'update users set';
        $query_arr = array();

        if($new_settings->GetGrade() != '')
        {
          $query = $query . ' grade = ?';
          array_push($query_arr, $new_settings->GetGrade());
          $current_settings->SetGrade($new_settings->GetGrade());
        }

        if($new_settings->GetDepartment() != '')
        {
          $query = $query . ' department = ?';
          array_push($query_arr, $new_settings->GetDepartment());
          $current_settings->SetDepartment($new_settings->GetDepartment());
        }

        if($new_settings->GetAbout() != '')
        {
          $query = $query . ' about = ?';
          array_push($query_arr, $new_settings->GetAbout());
          $current_settings->SetAbout($new_settings->GetAbout());
        }
        else
        {
          $query = $query . ' about = null,';
          $current_settings->SetAbout('');
        }

        $query = $query . ' will_teach = ?';
        array_push($query_arr, $new_settings->GetWillTeach());
        $current_settings->SetWillTeach($new_settings->GetWillTeach());

        if($new_settings->GetPhoto() != '')
        {
          $query = $query . ' photo = ?';
          array_push($query_arr, $new_settings->GetPhoto());
          $current_settings->SetPhoto($new_settings->GetPhoto());
        }

        $query = str_replace('? ', '?,', $query);
        $query = $query . ' where school_email = ?';
        array_push($query_arr, $current_settings->GetSchoolEmail());

        DB::update($query, $query_arr);

        $r->session()->forget('user');
        $r->session()->put('user', $current_settings);

        return response(['title' => 'Successful!', 'content' => 'New settings saved successfully.', 'status' => 'success']);
      }
    }
    catch(Exception $e)
    {
      return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
    }
  }

  public function PostSendM(Request $r)
  {
    try
    {
      if(!empty($r->userid))
      {
        if(!empty($r->message))
        {
          $mes = new Message();
          $mes->SetOwnerUser($r->userid);
          $mes->SetFromUser($r->session()->get('user')->GetID());
          $mes->SetContent($r->message);

          DB::insert('insert into messages(owner_user, from_user, content) values(?, ?, ?)', [$mes->GetOwnerUser(), $mes->GetFromUser(), $mes->GetContent()]);

          return response(['title' => 'Successful!', 'content' => 'Your message sent successfully.', 'status' => 'success']);
        }
        else
          return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
      }
      else
        return redirect('profile');
    }
    catch(Exception $e)
    {
      return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
    }
  }

  public function PostSendR(Request $r)
  {
    try
    {
      if(!empty($r->userid))
      {
        if(!empty($r->topic))
        {
          if($r->adate != 'Select a study date')
          {
            if($r->aplace != -1)
            {
              DB::insert('insert into appointments(owner_user, with_user, adate, place, content, sent_by_owner) values(?, ?, ?, ?, ?, ?)', [$r->userid, $r->session()->get('user')->GetID(), $r->adate, $r->aplace, $r->topic, 0]);

              DB::insert('insert into appointments(owner_user, with_user, adate, place, content, sent_by_owner) values(?, ?, ?, ?, ?, ?)', [$r->session()->get('user')->GetID(), $r->userid, $r->adate, $r->aplace, $r->topic, 1]);

              return response(['title' => 'Successful!', 'content' => 'Your request sent successfully.', 'status' => 'success']);
            }
            else
              return response(['title' => 'Empty fields!', 'content' => 'Please select a study place.', 'status' => 'error']);
          }
          else
            return response(['title' => 'Empty fields!', 'content' => 'Please select a study date.', 'status' => 'error']);
        }
        else
          return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
      }
      else
        return redirect('profile');
    }
    catch(Exception $e)
    {
      return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
    }
  }

  public function PostCreateAnno(Request $r)
  {
    try
    {
      if(!empty($r->topic))
      {
        if($r->sdate != 'Select a study date')
        {
          if($r->shour != 'Select a study hour')
          {
            if($r->splace != -1)
            {
              DB::insert('insert into announcements(owner_user, content, adate, place) values(?, ?, ?, ?)', [$r->session()->get('user')->GetID(), $r->topic, $r->sdate . ', ' . $r->shour, $r->splace]);

              return response(['title' => 'Successful!', 'content' => 'Your announcement created successfully.', 'status' => 'success']);
            }
            else
              return response(['title' => 'Empty fields!', 'content' => 'Please select a study place.', 'status' => 'error']);
          }
          else
            return response(['title' => 'Empty fields!', 'content' => 'Please select a study hour.', 'status' => 'error']);
        }
        else
          return response(['title' => 'Empty fields!', 'content' => 'Please select a study date.', 'status' => 'error']);
      }
      else
        return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
    }
    catch(Exception $e)
    {
      return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
    }
  }

  public function PostAnno(Request $r)
  {
    $page = Input::get('page');
    $sort = Input::get('sort');
    $show = Input::get('show');
    $search = rawurldecode(Input::get('search'));

    foreach($_POST as $k => $v)
    {
      if($v == 'Cancel')
        DB::delete('delete from announcements where id = ?', [(int)$k]);
      else if($v == 'Answer')
      {
        $res = DB::select('select * from announcements where id = ?', [(int)$k]);

        DB::insert('insert into appointments(owner_user, with_user, adate, place, content, sent_by_owner) values(?, ?, ?, ?, ?, ?)', [(int)$res[0]->owner_user, $r->session()->get('user')->GetID(), $res[0]->adate, (int)$res[0]->place, $res[0]->content, 1]);

        DB::insert('insert into appointments(owner_user, with_user, adate, place, content, sent_by_owner) values(?, ?, ?, ?, ?, ?)', [$r->session()->get('user')->GetID(), (int)$res[0]->owner_user, $res[0]->adate, (int)$res[0]->place, $res[0]->content, 0]);

        $rep = (int)$res[0]->replied + 1;

        DB::update('update announcements set replied = ? where id = ?', [$rep, (int)$k]);
      }
      else
        $search = $r->search;
    }

    return redirect('announcements?page=' . $page . '&sort=' . $sort . '&show=' . $show . '&search=' . rawurlencode($search));
  }

  public function PostAppo(Request $r)
  {
    $page = Input::get('page');
    $show = Input::get('show');
    $search = rawurldecode(Input::get('search'));

    try
    {
      foreach($_POST as $k => $v)
      {
        if($v == 'Accept')
        {
          $res = DB::select('select * from appointments where id = ? or content = (select content from appointments where id = ?)', [(int)$k, (int)$k]);

          for($i = 0; $i < count($res); $i++)
          {
            DB::update('update appointments set accepted = 1 where id = ?', [$res[$i]->id]);

            if((int)$res[$i]->with_user != $r->session()->get('user')->GetID())
            {
              $mes = 'I accepted your study request. See you at study date and place.<br><br><a href="appointment?id=' . $res[$i]->id . '">Appointment details</a>';

              DB::insert('insert into messages(owner_user, from_user, content) values(?, ?, ?)', [$res[$i]->with_user, $r->session()->get('user')->GetID(), $mes]);
            }

            $curr_date = new CurrentDate();
            $curr_date->GetCurrentDateString();

            $app_date = str_replace(' ', '', $res[$i]->adate);
            $app_date = str_replace('A', 'a', $app_date);
            $app_date = explode(',', $app_date);

            $hours = '';

            if($curr_date->date1 == $app_date[0])
              $hours = 'hours1';
            else if($curr_date->date2 == $app_date[0])
              $hours = 'hours2';
            else if($curr_date->date3 == $app_date[0])
              $hours = 'hours3';
            else if($curr_date->date4 == $app_date[0])
              $hours = 'hours4';
            else if($curr_date->date5 == $app_date[0])
              $hours = 'hours5';
            else if($curr_date->date6 == $app_date[0])
              $hours = 'hours6';
            else if($curr_date->date7 == $app_date[0])
              $hours = 'hours7';

            $res_user = DB::select('select freetime_json from users where id = ?', [$res[$i]->owner_user]);

            $table = FreetimeTable::DecodeTable($res_user[0]->freetime_json);
            $table = FreetimeTable::EditTable($table, $hours, $app_date[1], 'appointment', 1);
            $table = FreetimeTable::EncodeTable($table);

            DB::update('update users set freetime_json = ? where id = ?', [$table, $res[$i]->owner_user]);
          }
        }
        else if($v == 'Cancel')
        {
          $res = DB::select('select * from appointments where id = ? or content = (select content from appointments where id = ?)', [(int)$k, (int)$k]);

          for($i = 0; $i < count($res); $i++)
          {
            if((int)$res[$i]->owner_user == $r->session()->get('user')->GetID())
              DB::delete('delete from appointments where id = ?', [(int)$k]);
            
            if((int)$res[$i]->owner_user != $r->session()->get('user')->GetID())
            {
              DB::update('update appointments set accepted = -2 where id = ?', [$res[$i]->id]);

              $mes = 'I am so sorry however I have to cancel our appointment for some reasons.<br><br><a href="appointment?id=' . $res[$i]->id . '">Appointment details</a>';

              DB::insert('insert into messages(owner_user, from_user, content) values(?, ?, ?)', [$res[$i]->owner_user, $r->session()->get('user')->GetID(), $mes]);
            }

            $curr_date = new CurrentDate();
            $curr_date->GetCurrentDateString();

            $app_date = str_replace(' ', '', $res[$i]->adate);
            $app_date = str_replace('A', 'a', $app_date);
            $app_date = explode(',', $app_date);

            $hours = '';

            if($curr_date->date1 == $app_date[0])
              $hours = 'hours1';
            else if($curr_date->date2 == $app_date[0])
              $hours = 'hours2';
            else if($curr_date->date3 == $app_date[0])
              $hours = 'hours3';
            else if($curr_date->date4 == $app_date[0])
              $hours = 'hours4';
            else if($curr_date->date5 == $app_date[0])
              $hours = 'hours5';
            else if($curr_date->date6 == $app_date[0])
              $hours = 'hours6';
            else if($curr_date->date7 == $app_date[0])
              $hours = 'hours7';

            $res_user = DB::select('select freetime_json from users where id = ?', [$res[$i]->owner_user]);

            $table = FreetimeTable::DecodeTable($res_user[0]->freetime_json);
            $table = FreetimeTable::EditTable($table, $hours, $app_date[1], 'appointment', 0);
            $table = FreetimeTable::EncodeTable($table);

            DB::update('update users set freetime_json = ? where id = ?', [$table, $res[$i]->owner_user]);
          }
        }
        else if($v == 'Delete')
          DB::delete('delete from appointments where id = ?', [(int)$k]);
        else
          $search = $r->search;
      }
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }

    return redirect('appointments?page=' . $page . '&show=' . $show . '&search=' . rawurlencode($search));
  }

  public function PostCanAppo(Request $r)
  {
    if(!empty($r->appid))
    {
      try
      {
        DB::delete('delete from appointments where id = ?', [(int)$r->appid]);

        return redirect('appointments?page=1&show=all&search=');
      }
      catch(Exception $e)
      {
        return 'ERROR!';
      }
    }
    else
      return redirect('appointments?page=1&show=all&search=');
  }

  public function PostRatAppo(Request $r)
  {
    try
    {
      $res = DB::select('select * from appointments where id = ? or content = (select content from appointments where id = ?)', [(int)$r->appid, (int)$r->appid]);

      for($i = 0; $i < count($res); $i++)
      {
        DB::update('update appointments set completed = 1, point = ? where id = ?', [(int)$r->rate, (int)$res[$i]->id]);

        $curr_date = new CurrentDate();
        $curr_date->GetCurrentDateString();

        $app_date = str_replace(' ', '', $res[$i]->adate);
        $app_date = str_replace('A', 'a', $app_date);
        $app_date = explode(',', $app_date);

        $hours = '';

        if($curr_date->date1 == $app_date[0])
          $hours = 'hours1';
        else if($curr_date->date2 == $app_date[0])
          $hours = 'hours2';
        else if($curr_date->date3 == $app_date[0])
          $hours = 'hours3';
        else if($curr_date->date4 == $app_date[0])
          $hours = 'hours4';
        else if($curr_date->date5 == $app_date[0])
          $hours = 'hours5';
        else if($curr_date->date6 == $app_date[0])
          $hours = 'hours6';
        else if($curr_date->date7 == $app_date[0])
          $hours = 'hours7';

        $res_user = DB::select('select freetime_json from users where id = ?', [$res[$i]->owner_user]);

        $table = FreetimeTable::DecodeTable($res_user[0]->freetime_json);
        $table = FreetimeTable::EditTable($table, $hours, $app_date[1], 'appointment', 0);
        $table = FreetimeTable::EncodeTable($table);

        DB::update('update users set freetime_json = ? where id = ?', [$table, $res[$i]->owner_user]);
      }

      return redirect('appointments?page=1&show=all&search=');
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }

  public function PostContact(Request $r)
  {
    try
    {
      if(!empty($r->name) && !empty($r->email) && !empty($r->message))
      {
        if(filter_var($r->email, FILTER_VALIDATE_EMAIL))
        {
          DB::insert('insert into feedbacks(username, useremail, message) values(?, ?, ?)', [$r->name, $r->email, $r->message]);

          return response(['title' => 'Successful!', 'content' => 'We got your message and we will back to you soon.', 'status' => 'success']);
        }
        else
          return response(['title' => 'Invalid email!', 'content' => 'Please enter a valid email.', 'status' => 'error']);
      }
      else
        return response(['title' => 'Empty fields!', 'content' => 'Please fill all required fields.', 'status' => 'error']);
    }
    catch(Exception $e)
    {
      return response(['title' => 'Error!', 'content' => 'Something went wrong!', 'status' => 'error']);
    }
  }

  public function PostFindPair(Request $r)
  {
    try
    {
      $page = Input::get('page');
      $sort = Input::get('sort');
      $search = rawurldecode(Input::get('search'));
      
      if(isset($r->search))
        $search = $r->search;

      return redirect('find-pair?page=' . $page . '&sort=' . $sort . '&search=' . rawurlencode($search));
    }
    catch(Exception $e)
    {
      return 'ERROR!';
    }
  }
}











































