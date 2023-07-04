<?php
    $SignupDisplayMsg = false;
    $SignupEmailUnique = false;
    $SignupPassMatching = false;
    $SignupPhoneNumValid = false;
    $SignupSuccessful = false;
	
    if(isset($_POST["SignupSubmit"])) {
        $NewEmail = $_POST["email"];
        $sql = "SELECT email FROM customers where email = '$NewEmail'";
        $result = $con->query($sql);
        if($result->num_rows == 0) {
            $SignupEmailUnique = true;
        }
        $first_name = $_POST["firstname"];
        $last_name = $_POST["lastname"];
        $phonenumber = $_POST["phone"];
        $pass1 = $_POST["pass1"];
        $pass2 = $_POST["pass2"];
        if($pass1 == $pass2) {
            $SignupPassMatching = true;
        }
        if(is_numeric($phonenumber) && strlen($phonenumber) == 11) {
            $SignupPhoneNumValid = true;
        }
        if($SignupEmailUnique && $SignupPassMatching && $SignupPhoneNumValid) {
            //password requires something like hashing, inserts binary.
            $sql = "INSERT INTO customers (firstName, lastName, phoneNumber, email, password) VALUES ('$first_name', '$last_name', '$phonenumber', '$NewEmail', '$pass1')";
            $result = $con->query($sql);
            $SignupSuccessful = true;
        }
        unset($_POST["SignupSubmit"]);
		$SignupDisplayMsg = true;
    }
?>