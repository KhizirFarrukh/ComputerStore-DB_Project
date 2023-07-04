<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    if(isset($_POST['update']))
    {
        $LoggedInUser = $_SESSION["userID"];
        $pass1 = $_POST["password1"];
        $pass2 = $_POST["password2"];
        if($pass1 == $pass2) {
            //password requires something like hashing, inserts binary.
            $sql = "UPDATE customers SET `password` = '$pass1' WHERE id = $LoggedInUser";
            if($con->query($sql)) {
                echo '<script type="text/javascript"> alert("Updated Successfully") </script>';
            } else {
                die($con->error);
            }
        } else {
            echo '<script type="text/javascript"> alert("Passwords not matching") </script>';
        }
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> UpdatePassword </title>
        <style>
            body{
                background-color: whitesmoke;
            }
            input{
                width: 30%;
                height: 5%;
                border: none;
                border-radius: 5px;
                padding: 8px 15px;
                margin: 10px 0px;
                box-shadow: 1px 2px grey;
            }
            .body {
                margin-left: 20%;
                font-family: sans-serif;
            }
        </style>
    </head>
    <body>
        <?php
            include "HeaderFiles\\PageHeader.php";
        ?>
        <div class="body">
            <h1>Reset Password</h1>
            <form action="updatePassword.php" method="POST">
                <input type="password" name="password1" placeholder="Enter New Password" required>
                <br>
                <input type="password" name="password2" placeholder="Retype New Password" required>
                <br>
                <input type="submit" name="update" value="Save">
                <br>
            </form>
        </div>
    </body>
</html>