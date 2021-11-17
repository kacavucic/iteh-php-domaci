<?php

class Appointment
{
    public $id;
    public DateTime $date_time;
    public ?Dog $dog;
    public ?Location $location;

    public function __construct($id = null, DateTime $date_time = null, ?Dog $dog = null, ?Location $location = null)
    {
        $this->id = $id;
        $this->date_time = $date_time;
        $this->dog = $dog;
        $this->location = $location;
    }
}