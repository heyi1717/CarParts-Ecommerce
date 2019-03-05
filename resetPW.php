<?php
    include("config.php");
    include('session1.php');
    $error = "";
    $mes = "";
   
    if(!$db){
        die('Could not connect: '. mysqli_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $user_check = $_SESSION['userName'];
        $password = mysqli_real_escape_string($db,$_POST['password']);
        $password1 = mysqli_real_escape_string($db,$_POST['password1']);
        //Password Hashing
        $randString = "WangZheRongYao";
        $hashedPwd = password_hash($userName.$password.$randString, PASSWORD_DEFAULT);
        
        if($password == $password1) {
            //Building the query
            $sql = "update Users set Password = '$password', Salt = '$hashedPwd' where UName = '$user_check'";

            if ($db->query($sql) === TRUE) {
                $mes= "Your Password update successfully";
                //header("location: admin.php");
            } else {
                $error=  $sql . "<br>" . $db->error;
            }
        } else {
            $error = "Password not matched, please try again.";
        }
    }
    $db->close();
    ?>
<!DOCTYPE html>
<html>
<head>
<title>User |  PW Reset</title>
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
                        <center>
                        <h1>UTEP Auto Store</h1>
                        <h2>User Password Reset</h2>
                        </center>
                  </div>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                <center><p style="color:#009966"><?php echo $mes; ?></p>
                <center><p style="color:#ff0000"><?php echo $error; ?></p>
                  <form id="register-form" method="POST">
                <center>
                    <div class="login">
                    <input type="text" placeholder="Password" name="password">
                    <input type="text" placeholder="Re-Enter Password" name="password1">
                    <input type="submit" value="Submit">
                    </div>
                    <a href="user.php" class="signup">User Page</a>
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
