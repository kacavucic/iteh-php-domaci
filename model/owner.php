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

    public static function getAll(mysqli $conn): ?array
    {
        $query = "SELECT * FROM owner";
        $result = $conn->query($query);
        if (!$result) {
            echo "Error while retrieving data";
            return null;
        }
        if ($result->num_rows == 0) {
            echo "No owners currently";
            return null;
        } else {
            $owners = array();
            while ($row = $result->fetch_array()) {
                $owner = new Owner($row["owner_id"], $row["first_name"], $row["last_name"], $row["phone_number"]);
                array_push($owners, $owner);
            }
            return $owners;
        }
    }

    public static function getById($id, mysqli $conn): ?Owner
    {
        $query = "SELECT * FROM owner WHERE owner_id=$id";
        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_array(1);
            return new Owner($row["owner_id"], $row["first_name"], $row["last_name"], $row["phone_number"]);
        } else {
            return null;
        }
    }
}
