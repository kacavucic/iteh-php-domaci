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

    public static function getAll(mysqli $conn): ?array
    {
        $query = "SELECT * FROM location";
        $result = $conn->query($query);

        if (!$result) {
            echo "Error while retrieving data";
            return null;
        }
        if ($result->num_rows == 0) {
            echo "No locations currently";
            return null;
        } else {
            $locations = array();
            while ($row = $result->fetch_array()) {
                $location = new Location($row["location_id"], $row["city"], $row["address"]);
                array_push($locations, $location);
            }
            return $locations;
        }
    }

    public static function getById($id, mysqli $conn): ?Location
    {
        $query = "SELECT * FROM location WHERE location_id=$id";
        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_array(1);
            return new Location($row["location_id"], $row["city"], $row["address"]);
        } else {
            return null;
        }
    }
}