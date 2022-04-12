<?php
require "../dbBroker.php";
require "../model/location.php";
require "../model/owner.php";
require "../model/dog.php";
require "../model/appointment.php";

if (isset($_POST['idEdit']) && isset($_POST['appointmentTimeEdit']) && isset($_POST['dogEdit']) && isset($_POST['locationEdit'])) {

    $owner_dog = Dog::getById($_POST['dogEdit'], $conn);
    $location = Location::getById($_POST['locationEdit'], $conn);
    $date_time = new DateTime($_POST['appointmentTimeEdit']);

    $appointment = new Appointment($_POST['idEdit'], $date_time, $owner_dog, $location);
    $status = Appointment::update($appointment, $conn);

    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}