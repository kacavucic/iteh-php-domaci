<?php
require "../dbBroker.php";
require "../model/appointment.php";
require "../model/owner.php";
require "../model/dog.php";
require "../model/location.php";

if (isset($_POST['id'])) {
    $appointment = Appointment::getById($_POST['id'], $conn);
    echo json_encode($appointment);
}