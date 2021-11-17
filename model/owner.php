<?php

class Owner
{
    public $id;
    public $firstname;
    public $lastname;
    public $phoneNumber;

    public function __construct($id = null, $firstname = null, $lastname = null, $phoneNumber = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phoneNumber = $phoneNumber;
    }
}