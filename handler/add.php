<?php
require "../dbBroker.php";
require "../model/location.php";
require "../model/owner.php";
require "../model/dog.php";
require "../model/appointment.php";

if (isset($_POST['appointmentTime']) && isset($_POST['dog']) && isset($_POST['location'])) {

    $owner_dog = Dog::getById($_POST['dog'], $conn);
    $location = Location::getById($_POST['location'], $conn);
    $date_time = new DateTime($_POST['appointmentTime']);

    $appointment = new Appointment(null, $date_time, $owner_dog, $location);
    $status = Appointment::add($appointment, $conn);

    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
