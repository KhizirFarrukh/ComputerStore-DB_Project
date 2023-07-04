<?php
    if(isset($_SESSION["userID"])) {
        $sql = "SELECT firstName, lastName FROM customers WHERE id = " . $_SESSION["userID"];
        $result = $con->query($sql) or die($con->error);
        $row = $result->fetch_assoc();
        $UserName = $row["firstName"] . " " . $row["lastName"];
    } else {
        $UserName = "";
    }
?>