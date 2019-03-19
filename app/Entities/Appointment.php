<?php

  namespace App\Entities;

  class Appointment
  {
    private $id;
    private $owner_user;
    private $with_user;
    private $adate;
    private $place;
    private $point;
    private $content;
    private $accepted;
    private $sent_by_owner;
    private $created;
    private $completed;

    public function __construct($id = -1, $owner_user = -1, $with_user = -1,
                                $adate = '', $place = -1, $point = -1, $content = '',
                                $accepted = -1, $sent_by_owner = -1, $completed = -1, $created = '')
    {
      $this->id = $id;
      $this->owner_user = $owner_user;
      $this->with_user = $with_user;
      $this->adate = $adate;
      $this->place = $place;
      $this->point = $point;
      $this->content = $content;
      $this->accepted = $accepted;
      $this->sent_by_owner = $sent_by_owner;
      $this->created = $created;
      $this->completed = $completed;
    }

    public function SetID($id)
    {
      $this->id = $id;
    }

    public function SetOwnerUser($owner_user)
    {
      $this->owner_user = $owner_user;
    }

    public function SetWithUser($with_user)
    {
      $this->with_user = $with_user;
    }

    public function SetDate($adate)
    {
      $this->adate = $adate;
    }

    public function SetPlace($place)
    {
      $this->place = $place;
    }

    public function SetPoint($point)
    {
      $this->point = $point;
    }

    public function SetContent($content)
    {
      $this->content = $content;
    }

    public function SetAccepted($accepted)
    {
      $this->accepted = $accepted;
    }

    public function SetSentByOwner($sent_by_owner)
    {
      $this->sent_by_owner = $sent_by_owner;
    }

    public function SetCreated($created)
    {
      $this->created = $created;
    }

    public function SetCompleted($completed)
    {
      $this->completed = $completed;
    }

    public function GetID()
    {
      return $this->id;
    }

    public function GetOwnerUser()
    {
      return $this->owner_user;
    }

    public function GetWithUser()
    {
      return $this->with_user;
    }

    public function GetDate()
    {
      return $this->adate;
    }

    public function GetPlace()
    {
      return $this->place;
    }

    public function GetPoint()
    {
      return $this->point;
    }

    public function GetContent()
    {
      return $this->content;
    }

    public function GetAccepted()
    {
      return $this->accepted;
    }

    public function GetSentByOwner()
    {
      return $this->sent_by_owner;
    }

    public function GetCreated()
    {
      return $this->created;
    }

    public function GetCompleted()
    {
      return $this->completed;
    }
  }













































