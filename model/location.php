<?php

class Location
{
    public $id;
    public $city;
    public $address;

    public function __construct($id = null, $city = null, $address = null)
    {
        $this->id = $id;
        $this->city = $city;
        $this->address = $address;
    }
}