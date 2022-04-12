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

    public static function getAll(mysqli $conn): ?array
    {
        $query = "SELECT * FROM appointment a JOIN dog d ON a.dog_id = d.dog_id 
        JOIN owner o ON d.owner_id = o.owner_id 
        JOIN location l ON a.location_id = l.location_id";
        $result = $conn->query($query);
        if (!$result) {
            echo "Error while retrieving data";
            return null;
        }
        if ($result->num_rows == 0) {
            echo "No appointments currently";
            return null;
        } else {
            $appointments = array();
            while ($row = $result->fetch_array()) {
                $owner = new Owner($row["owner_id"], $row["first_name"], $row["last_name"], $row["phone_number"]);
                $dog = new Dog($row["dog_id"], $owner, $row["breed"]);
                $location = new Location($row["location_id"], $row["city"], $row["address"]);
                $date_time = new DateTime($row["date_time"]);
                $appointment = new Appointment($row["appointment_id"], $date_time, $dog, $location);
                array_push($appointments, $appointment);
            }
            return $appointments;
        }
    }

    public static function add(Appointment $appointment, mysqli $conn)
    {
        $location_id = $appointment->location->id;
        $dog_id = $appointment->dog->id;
        $date_time = $appointment->date_time->format("Y-m-d H:i:s");
        $query = "INSERT INTO appointment(date_time,dog_id,location_id) 
        VALUES('$date_time',$dog_id, $location_id)";

        return $conn->query($query);
    }

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM appointment WHERE appointment_id=$this->id";
        return $conn->query($query);
    }

    public static function getById($id, mysqli $conn): ?Appointment
    {
        $query = "SELECT * FROM appointment a JOIN dog d ON a.dog_id = d.dog_id 
        JOIN owner o ON d.owner_id = o.owner_id 
        JOIN location l ON a.location_id = l.location_id WHERE appointment_id=$id";

        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_array(1);
            $owner = new Owner($row["owner_id"], $row["first_name"], $row["last_name"], $row["phone_number"]);
            $dog = new Dog($row["dog_id"], $owner, $row["breed"]);
            $location = new Location($row["location_id"], $row["city"], $row["address"]);
            $date_time = new DateTime($row["date_time"]);
            return new Appointment($row["appointment_id"], $date_time, $dog, $location);
        } else {
            return null;
        }
    }

    public static function update(Appointment $appointment, mysqli $conn)
    {
        $location_id = $appointment->location->id;
        $dog_id = $appointment->dog->id;
        $date_time = $appointment->date_time->format("Y-m-d H:i:s");

        $query = "UPDATE appointment SET 
        date_time = ' $date_time',
        dog_id = $dog_id,
        location_id = $location_id
        WHERE appointment_id=$appointment->id";

        return $conn->query($query);
    }
}
