<?php
require "./dbBroker.php";
require "./model/dog.php";

if (!isset($_POST['selected_owner'])) {
    echo "";
} else {
    $selected_owner = $_POST['selected_owner'];
    $selected_dog = "";

    if (isset($_POST['selected_dog'])) {
        $selected_dog = $_POST['selected_dog'];
    }

    $dogs = Dog::getAllByOwnerId($selected_owner, $conn);

    if ($dogs != null) {
        $resultHtml = "";
        foreach ($dogs as $dog) {
            if ($dog->id == $selected_dog) {
                $resultHtml = $resultHtml . "<option value=\"" . $dog->id . "\" selected>" . $dog->breed . "</option>";
            } else {
                $resultHtml = $resultHtml . "<option value=\"" . $dog->id . "\">" . $dog->breed . "</option>";
            }
        }
        echo $resultHtml;
    }
}
