<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    include "HeaderFiles\\LoginValidation.php";
    include "HeaderFiles\\AccountCreation.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/NavBar.css">
    <link rel="stylesheet" href="./css/PageHeader.css">
</head>

<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
        if(isset($_SESSION["userID"])) {
            echo "You are already logged in";
        }
    ?>
    <div class="LoginBody">
        <h4 style="margin-left:5%;font-size:18px;font-weight:normal;margin-bottom:10px;">Already have an account? Login...</h4>
        <div class="loginContainer">
            <form action="login.php" method="POST">
                <table>
                    <tr>
                        <th align="left">Email Address</th>
                        <th><input class="inputBox" type="email" name="email" placeholder="abc@example.com" id="emailID" style="margin-left:67px;" required></th>
                    </tr>
                    <tr>
                        <th align="left">Password</th>
                        <th><input class="inputBox" type="password" name="password" id="Password1" style="margin-left:67px;" required></th>
                    </tr>
                </table>
                <br>
                <button ID="loginProceed" type="submit" name="LoginSubmit" style="margin-left:245px;width:80px;height:30px;margin-bottom:20px;">Log in</button>
            </form>
            <?php
                if($LoginDisplayMsg == true) {
                    if($loginSuccessful == false) {
                        echo "<span><h3 style=\"color:red;font-size:18px\">*Email address or Password is incorrect </h3></span>";
                    }
                }
            ?>
            <br>
        </div>
        <hr style="width:570px">
        <h4 style="margin-top:20px;margin-left:5%;font-size:18px;font-weight:normal;margin-bottom:10px;">Don't have an account? Signup...</h4>
        <div class="signupContainer">
            <form action="login.php" method="POST">
                <table>
                    <tr>
                        <th align="left">First name</th>
                        <th><input type="text" class="inputBox" id="FirstName" name="firstname" style="margin-left:10px;" required></th>
                    </tr>
                    <tr>
                        <th align="left">Last name</th>
                        <th><input type="text" class="inputBox" id="LastName" name="lastname" style="margin-left:10px;" required></th>
                    </tr>
                    <tr>
                        <th align="left">Mobile Number</th>
                        <th><input type="text" class="inputBox" placeholder="03XX-XXXXXXX" id="CellNum" name="phone" style="margin-left:10px;" required></th>
                    </tr>
                    <tr>
                        <th align="left">Email Address</th>
                        <th><input type="email" class="inputBox" placeholder="abc@example.com" id="emailID" name="email" style="margin-left:10px;" required>
                        </th>
                    </tr>
                    <tr>
                        <th align="left">New Password</th>
                        <th><input type="password" class="inputBox" id="Password1" name="pass1" style="margin-left:10px;" minlength="8" required></th>
                    </tr>
                    <tr>
                        <th align="left">Re-Enter Password</th>
                        <th><input type="password" class="inputBox" id="Password2" name="pass2" style="margin-left:10px;" minlength="8" required></th>
                    </tr>
                </table>
                <br>
                <button ID="CreateAccount" name="SignupSubmit" style="margin-left:245px;width:150px;height:30px;" onclick="CreateAccount()">Create Account</button>
                <br>
            </form>
            <?php
                if($SignupDisplayMsg == true) {
                    if($SignupSuccessful == true) {
                        echo "Account Successfully created, please login";
                    } else {
                        if($SignupEmailUnique == false) {
                            echo "This email address is already taken by someone else, if it's you then please login";
                        }
                        if($SignupPassMatching == false) {
                            echo "Your Passwords are not matching";
                        }
                        if($SignupPhoneNumValid == false) {
                            echo "Please enter a valid phone number";
                        }
                    }
                }
            ?>
        </div>
    </div>


</div>
</body>

</html>