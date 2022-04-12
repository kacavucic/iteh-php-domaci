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

    public static function getAllByOwnerId($id, mysqli $conn): ?array
    {
        $query = "SELECT *  FROM dog d JOIN owner o ON d.owner_id=o.owner_id WHERE d.owner_id=$id";
        $result = $conn->query($query);
        if (!$result) {
            echo "Error while retrieving data";
            return null;
        }
        if ($result->num_rows == 0) {
            echo "No dogs by owner";
            return null;
        } else {
            $dogs = array();
            while ($row = $result->fetch_array()) {
                $dog = new Dog($row["dog_id"], null, $row["breed"]);
                array_push($dogs, $dog);
            }
            return $dogs;
        }
    }

    public static function getById($id, mysqli $conn): ?Dog
    {
        $query = "SELECT *  FROM dog d JOIN owner o ON d.owner_id=o.owner_id WHERE dog_id=$id";

        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_array(1);
            $owner = new Owner($row["owner_id"], $row["first_name"], $row["last_name"], $row["phone_number"]);
            return new Dog($row["dog_id"], $owner, $row["breed"]);
        } else {
            return null;
        }
    }
}
