<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "thecomputerstore";
    $con = mysqli_connect($server, $username, $password, $database);
    if(!$con) {
        die("error in connecting to db");
    }
?>