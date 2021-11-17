<?php

class Dog
{
    public $id;
    public ?Owner $owner;
    public $breed;

    public function __construct($id = null, ?Owner $owner = null, $breed = null)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->breed = $breed;
    }
}