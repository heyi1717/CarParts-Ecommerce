<?php
    include("config.php");
    include('session.php');
    $error = "";
    $mes = "";
   
    if(!$db){
        die('Could not connect: '. mysqli_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $userName = mysqli_real_escape_string($db,$_POST['username']);
        $password = mysqli_real_escape_string($db,$_POST['password']);
        //Password Hashing
        $randString = "WangZheRongYao";
        $hashedPwd = password_hash($userName.$password.$randString, PASSWORD_DEFAULT);
        
        //Building the query
        $sql = "update Users set Password = '$password', Salt = '$hashedPwd' where UName = '$userName'";

        if ($db->query($sql) === TRUE) {
            $mes= "Costomer: " . $userName. " update successfully";
            //header("location: admin.php");
        } else {
            $error=  $sql . "<br>" . $db->error;
        }
    }
    $db->close();
    ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin |  PW Reset</title>
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
                        <h2>Reset Customer Password</h2>
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
                    <input type="text" placeholder="Username" name="username">
                    <input type="text" placeholder="Password" name="password">
                    <input type="submit" value="Submit">
                    </div>
                    <a href="admin.php" class="signup">Admin Page</a>
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
