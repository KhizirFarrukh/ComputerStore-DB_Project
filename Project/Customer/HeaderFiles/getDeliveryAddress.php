<?php
    $sql = "SELECT addressLine, state, city, zipCode FROM customeraddress where id = $LoggedinUser";
    $result = $con->query($sql) or die($con->error);
    $AddressFetched = false;
    if($result->num_rows > 0) {
        $AddressFetched = true;
        $row = $result->fetch_assoc();
        $AddressLine = $row["addressLine"];
        $State = $row["state"];
        $City = $row["city"];
        $Zipcode = $row["zipCode"];
    } else {
        $AddressLine = null;
        $State = null;
        $City = null;
        $Zipcode = null;
    }
?>