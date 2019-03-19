<?php

  namespace App\Entities;

  class User
  {
    private $id;
    private $school_email;
    private $name;
    private $surname;
    private $passwrd;
    private $grade;
    private $department;
    private $about;
    private $will_teach;
    private $photo;
    private $activated;
    private $created;
    private $table;

    public function __construct($school_email = '', $name = '', $surname = '',
                                $passwrd = '', $grade = '', $department = '', $photo = '',
                                $about = '', $will_teach = -1, $activated = -1, $created = '',
                                $table = '', $id = -1)
    {
      $this->id = $id;
      $this->school_email = $school_email;
      $this->name = $name;
      $this->surname = $surname;
      $this->passwrd = $passwrd;
      $this->grade = $grade;
      $this->department = $department;
      $this->about = $about;
      $this->will_teach = $will_teach;
      $this->photo = $photo;
      $this->activated = $activated;
      $this->created;
      $this->table = $table;
    }

    // Setters

    public function SetID($id)
    {
      $this->id = $id;
    }

    public function SetSchoolEmail($school_email)
    {
      $this->school_email = $school_email;
    }

    public function SetName($name)
    {
      $this->name = $name;
    }

    public function SetSurname($surname)
    {
      $this->surname = $surname;
    }

    public function SetPasswrd($passwrd)
    {
      $this->passwrd = $passwrd;
    }

    public function SetGrade($grade)
    {
      $this->grade = $grade;
    }

    public function SetDepartment($department)
    {
      $this->department = $department;
    }

    public function SetAbout($about)
    {
      $this->about = $about;
    }

    public function SetWillTeach($will_teach)
    {
      $this->will_teach = $will_teach;
    }

    public function SetPhoto($photo)
    {
      $this->photo = $photo;
    }

    public function SetActivated($activated)
    {
      $this->activated = $activated;
    }

    public function SetTable($table)
    {
      $this->table = $table;
    }

    // Getters

    public function GetID()
    {
      return($this->id);
    }

    public function GetSchoolEmail()
    {
      return($this->school_email);
    }

    public function GetName()
    {
      return($this->name);
    }

    public function GetSurname()
    {
      return($this->surname);
    }

    public function GetPasswrd()
    {
      return($this->passwrd);
    }

    public function GetGrade()
    {
      return($this->grade);
    }

    public function GetDepartment()
    {
      return($this->department);
    }

    public function GetAbout()
    {
      return($this->about);
    }

    public function GetWillTeach()
    {
      return($this->will_teach);
    }

    public function GetPhoto()
    {
      return($this->photo);
    }

    public function GetActivated()
    {
      return($this->activated);
    }

    public function GetCreated()
    {
      return($this->created);
    }

    public function GetTable()
    {
      return($this->table);
    }
  }














































