<?php
    $hostname = "localhost";
    $dbuser = "root";
    $dbPassword = "";
    $dbname = "personal_website";
    $conn = mysqli_connect($hostname, $dbuser, $dbPassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>