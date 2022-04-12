<?php
require "dbBroker.php";
require "model/location.php";
require "model/owner.php";
require "model/dog.php";
require "model/appointment.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dog Grooming Center</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown mr-3">
                    <i class="align-self-center fas fa-cut" aria-hidden="true"></i>
                    <a class="nav-link dropdown-toggle" style="display: inline-block;" href="#"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       data-bs-toggle="dropdown">Dog Grooming Center</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="">
                            <i class="align-self-center fas fa-users mr-2" aria-hidden="true"
                               style="color: dimgrey;"></i>Owners</a>
                        <a class="dropdown-item" href="">
                            <i class="align-self-center fas fa-map-marked-alt mr-2" aria-hidden="true"
                               style="color: dimgrey;"></i>Locations</a>
                    </div>
                </li>
                <li class="nav-item mr-2">
                    <i class="align-self-center far fa-calendar-check" aria-hidden="true"></i>
                    <a class="nav-link" href="">Appointments</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <i class="align-self-center fas fa-sign-out-alt" aria-hidden="true"></i>
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="dark-overlay">
    <div class="home-inner">
        <div class="container">
            <div class="row">
                <div class="card col-xs-12 table-container">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xs-12 col-md-2 ">
                                <select class="custom-select" id="search-appointments-dropdown">
                                    <option value="ID">ID</option>
                                    <option value="FirstName">Owner</option>
                                    <option value="LastName">Location</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-6 ">
                                <input type="text" id="searchAppointmentBar"
                                       placeholder="Search for appointments..." class="form-control search mr-2"
                                       aria-label="Text input with dropdown button"
                                       onkeyup="searchAppointmentByProperty()"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <table class="table table-responsive" id="appointmentTable">
                                    <thead class="thead">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date and time</th>
                                        <th>Owner</th>
                                        <th>Dog</th>
                                        <th id="location">Location</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody id="appointments-table-body">
                                    <?php
                                    $appointments = Appointment::getAll($conn);
                                    if ($appointments != null) {
                                        foreach ($appointments as $appointment) :
                                            ?>
                                            <tr>
                                                <td><?php echo $appointment->id ?></td>
                                                <td><?php echo $appointment->date_time->format("Y M j , g:i a") ?></td>
                                                <td><?php echo $appointment->dog->owner->firstname . " " . $appointment->dog->owner->lastname ?></td>
                                                <td><?php echo $appointment->dog->breed ?></td>
                                                <td><?php echo $appointment->location->city . ", " . $appointment->location->address ?></td>
                                                <td>
                                                    <button id="editAppointment"
                                                            class="fas fa-user-edit edit-appointment"
                                                            data-toggle="modal" data-target="#editModal"
                                                            title="Edit appointment"
                                                            value="<?php echo $appointment->id ?>">

                                                    </button>
                                                </td>
                                                <td>
                                                    <button id="deleteAppointment"
                                                            class="fas fa-user-times delete-appointment"
                                                            name="deleteAppointment"
                                                            title="Delete appointment"
                                                            value="<?php echo $appointment->id ?>">
                                                    </button>
                                                </td>

                                            </tr>
                                        <?php
                                        endforeach;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button id="btn-add" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#addModal">Make an Appointment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="mt-auto">
    <div class="row">
        <div class="col text-center">
            <span class="text-muted">Dog Grooming Center</span>
        </div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="https://kit.fontawesome.com/30083d8c18.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        console.log("READY");

        $('#appointmentTable').DataTable({
            "searching": false,
            "paging": false,
            "columnDefs": [
                {"orderable": false, "targets": [5, 6]}
            ]
        });

        $('.dataTables_length').addClass('bs-select');
    });

    function searchAppointmentByProperty() {
        let selectedProperty = $("#search-appointments-dropdown option:selected").text();
        input = document.getElementById("searchAppointmentBar");
        filter = input.value.toUpperCase();

        let table = document.getElementById("appointmentTable");
        let tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            switch (selectedProperty) {
                case "ID":
                    td = tr[i].getElementsByTagName("td")[0];
                    break;
                case "Owner":
                    td = tr[i].getElementsByTagName("td")[2];

                    break;
                case "Location":
                    td = tr[i].getElementsByTagName("td")[4];
                    break;
                default:
            }
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</body>
</html>