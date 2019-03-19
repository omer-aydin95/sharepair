<?php

  namespace App\Entities;

  class Place
  {
    private $id;
    private $name;
    private $department;
    private $floor;
    private $max_capacity;

    public function __construct($id = -1, $name = '', $department = '', $floor = '', $max_capacity = -1)
    {
      $this->id = $id;
      $this->name = $name;
      $this->department = $department;
      $this->floor = $floor;
      $this->max_capacity = $max_capacity;
    }

    public function SetID($id)
    {
      $this->id = $id;
    }

    public function SetName($name)
    {
      $this->name = $name;
    }

    public function SetDepartment($department)
    {
      $this->department = $department;
    }

    public function SetFloor($floor)
    {
      $this->floor = $floor;
    }

    public function SetMaxCapacity($max_capacity)
    {
      $this->max_capacity = $max_capacity;
    }

    public function GetID()
    {
      return $this->id;
    }

    public function GetName()
    {
      return $this->name;
    }

    public function GetDepartment()
    {
      return $this->department;
    }

    public function GetFloor()
    {
      return $this->floor;
    }

    public function GetMaxCapacity()
    {
      return $this->max_capacity;
    }
  }

















































