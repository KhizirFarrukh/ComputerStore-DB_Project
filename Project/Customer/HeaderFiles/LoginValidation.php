<?php
    $LoginDisplayMsg = false;
    $loginSuccessful = false;
    if(isset($_POST["LoginSubmit"])) {
        if($_POST["email"])
        $useremail = $_POST["email"];
        $userpassword = $_POST["password"];
        //password requires something like hashing, works on binary.
        $sql = "SELECT id, `password` FROM customers where email = '$useremail'";
        $result = $con->query($sql);
        $id = NULL;
        if($result->num_rows>0) {
            $row = $result->fetch_assoc();
		    if($row["password"] == $userpassword) {
				$loginSuccessful = true;
                $id = $row["id"];
			}
        }
        if($loginSuccessful == true) {
            $_SESSION["userID"] = $id;
            header("Location: Products.php");
        }
        unset($_POST["LoginSubmit"]);
		$LoginDisplayMsg = true;
    }
?>