<?php
  
  namespace App\Entities;
  
  class Department
  {
    private $id;
    private $name;
    
    public function __construct($id = -1, $name = '')
    {
      $this->id = $id;
      $this->name = $name;
    }

    public function GetID()
    {
      return($this->id);
    }

    public function GetName()
    {
      return($this->name);
    }

    public function SetName($name)
    {
      $this->name = $name;
    }

    public function SetID($id)
    {
      $this->id = $id;
    }
  }

























































