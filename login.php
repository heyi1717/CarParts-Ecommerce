<?php
    //We include the configuration file
    include("config.php");
    $error = "";
    //$login = "Username: steveo420, Password: 1  |   admin1, admin1 for admin login.";
    $login="";

    //Start the session
    session_start();
   
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']);
       
        //Building the query
        $sql = "SELECT * FROM Users WHERE UName = '$myusername'";
       
        //Performs a query on the database
        $result = mysqli_query($db,$sql);
       
        //Fetch a result row as an associative, a numeric array, or both
        $row = mysqli_fetch_assoc($result);
       
        $randString = "WangZheRongYao";
        $hashedPwdCheck = password_verify($myusername.$mypassword.$randString, $row['Salt']);
        //echo "$hashedPwdCheck";
        $type = $row['Type'];
        
        if($hashedPwdCheck == true) {
                $_SESSION['userName'] = $myusername;
                $_SESSION['userType'] = $type;
                $login_time = "UPDATE Users SET lastLogin = CURRENT_TIMESTAMP WHERE UName = '$myusername'";
                mysqli_query($db,$login_time);
                
                if($type == "admin") {
                    header("location: admin.php");
                } else {
                    header("location: home.php");
                }
        }
        else {
            $error = "Your Login Name or Password is invalid";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign In</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="css/login.css" />
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
                    <h2>Sign In</h2>
                  </div>
                  <p></p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                <center><p style="color:#ff0000"><?php echo $error; ?></p></center>
                <center><p style="color:#ff0000"><?php echo $login; ?></p></center>
                  <form id="login-form" method="post" action="login.php">
                    <div class="login">
                    <input type="text" placeholder="Username" name="username">
                    <input type="password" placeholder="password" name="password">
                    <br>
                    <center><small>Do not have an account? </small></center><a href="register.php" class="forgot">Signup</a>
                    <input type="submit" value="Sign In">
                    </div>
                  </form>
                </center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
