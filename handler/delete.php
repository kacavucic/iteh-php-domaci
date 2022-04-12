<?php
require "../dbBroker.php";
require "../model/appointment.php";

if (isset($_POST['id'])) {

    $appointmentToDelete = new Appointment($_POST['id'], new DateTime(), null, null);
    $status = $appointmentToDelete->deleteById($conn);

    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}