<?php

$conn = mysqli_connect("localhost", "root", "", "pratica");

if (!$conn) {
    die("Connection Failed." . mysqli_connect_error());
} else {
    echo "";
}

?>