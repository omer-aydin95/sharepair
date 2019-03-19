<?php
  
  namespace App\Entities;

  class Message
  {
    private $id;
    private $owner_user;
    private $from_user;
    private $content;
    private $readed;
    private $date;

    public function __construct($id = -1, $owner_user = -1, $from_user = -1, $content = "", $readed = -1, $date = "")
    {
      $this->id = $id;
      $this->owner_user = $owner_user;
      $this->from_user = $from_user;
      $this->content = $content;
      $this->readed = $readed;
      $this->date = $date;
    }

    public function SetID($id)
    {
      $this->id = $id;
    }

    public function SetOwnerUser($owner_user)
    {
      $this->owner_user = $owner_user;
    }

    public function SetFromUser($from_user)
    {
      $this->from_user = $from_user;
    }

    public function SetContent($content)
    {
      $this->content = $content;
    }

    public function SetReaded($readed)
    {
      $this->readed = $readed;
    }

    public function SetDate($date)
    {
      $this->date = $date;
    }

    public function GetID()
    {
      return $this->id;
    }

    public function GetOwnerUser()
    {
      return $this->owner_user;
    }

    public function GetFromUser()
    {
      return $this->from_user;
    }

    public function GetContent()
    {
      return $this->content;
    }

    public function GetReaded()
    {
      return $this->readed;
    }

    public function GetDate()
    {
      return $this->date;
    }
  }

















































