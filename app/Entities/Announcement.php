<?php

  namespace App\Entities;

  class Announcement
  {
    private $id;
    private $owner_user;
    private $content;
    private $adate;
    private $place;
    private $replied;
    private $created;

    public function __construct($id = -1, $owner_user = -1, $content = '',
                                $adate = '', $place = -1, $replied = -1, $created = '')
    {
      $this->id = $id;
      $this->owner_user = $owner_user;
      $this->content = $content;
      $this->adate = $adate;
      $this->place = $place;
      $this->replied = $replied;
      $this->created = $created;
    }

    public function SetID($id)
    {
      $this->id = $id;
    }

    public function SetOwnerUser($owner_user)
    {
      $this->owner_user = $owner_user;
    }

    public function SetContent($content)
    {
      $this->content = $content;
    }

    public function SetDate($adate)
    {
      $this->adate = $adate;
    }

    public function SetPlace($place)
    {
      $this->place = $place;
    }

    public function SetReplied($replied)
    {
      $this->replied = $replied;
    }

    public function SetCreated($created)
    {
      $this->created = $created;
    }

    public function GetID()
    {
      return $this->id;
    }

    public function GetOwnerUser()
    {
      return $this->owner_user;
    }

    public function GetContent()
    {
      return $this->content;
    }

    public function GetDate()
    {
      return $this->adate;
    }

    public function GetPlace()
    {
      return $this->place;
    }

    public function GetReplied()
    {
      return $this->replied;
    }

    public function GetCreated()
    {
      return $this->created;
    }
  }















































