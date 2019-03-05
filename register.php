<?php
    include("config.php");
    $error = "";
    
    if(!$db){
        die('Could not connect: '. mysqli_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $firstName = mysqli_real_escape_string($db,$_POST['firstname']);
        $lastName = mysqli_real_escape_string($db,$_POST['lastname']);
        $userName = mysqli_real_escape_string($db,$_POST['username']);
        $passWord = mysqli_real_escape_string($db,$_POST['password']);
        $email = mysqli_real_escape_string($db,$_POST['email']);
        //Password Hashing
        $randString = "WangZheRongYao";
        $hashedPwd = password_hash($userName.$passWord.$randString, PASSWORD_DEFAULT);
        $userType = "reg_user";
        
        //Building the query
        $sql = "INSERT INTO Users VALUES ('$userName','$firstName','$lastName',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),'$passWord','$userType','$hashedPwd','$email')";
        
        if ($db->query($sql) === TRUE) {
                $error= "New record created successfully";
                header("location: login.php");
            } else {
                $error=  $sql . "<br>" . $db->error;
            }
        }
    $db->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="css/register.css" />
</head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <a href="home.php">Home Page</a>
                    <center>
                        <h1>UTEP | Auto Store</h1>
                        <h2>Sign up</h2>
                  </div>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form id="register-form" method="POST">
                    <div class="login">
                    <input type="text" placeholder="First Name" name="firstname">
                    <input type="text" placeholder="Last Name" name="lastname">
                    <input type="text" placeholder="Username" name="username">
                    <input type="email" placeholder="Email" name="email">
                    <input type="password" placeholder="Password" name="password">
                    <br>
                    <center><small>Already have an account?</small></center><a href="login.php" class="forgot">Login</a>
                    <input type="submit" value="Sign In">
                    </div>
                </center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </body>
</html>
