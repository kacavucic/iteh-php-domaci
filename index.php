<?php
require "dbBroker.php";
require "model/user.php";

session_start();

$loginError = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::loginUser($username, $password, $conn);

    if ($user != null) {
        $_SESSION['user_id'] = $user->id;
        header('Location: home.php');
        exit();
    } else {
        $loginError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/styleIndex.css">
    <title>Dog Grooming Center</title>
</head>
<body>
<div class="dark-overlay">
    <div class="home-inner">
        <div class="container">
            <div class="row">
                <div class="card col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="card-body">
                        <h4 class="card-title">Log In</h4>
                        <?php if ($loginError) : ?>
                            <p class="alert alert-danger">Invalid username or
                                password</p>
                        <?php endif; ?>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Enter password">
                            </div>
                            <button class="btn btn-primary" type="submit">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>