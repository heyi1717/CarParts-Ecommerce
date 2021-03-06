<?php
    include("config.php");
    include('session.php');
    $error = "";
    
    if(!$db){
        die('Could not connect: '. mysqli_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = mysqli_real_escape_string($db,$_POST['username']);
        $street1 = mysqli_real_escape_string($db,$_POST['street1']);
        $street2 = mysqli_real_escape_string($db,$_POST['street2']);
        $state = mysqli_real_escape_string($db,$_POST['state']);
        $zip = mysqli_real_escape_string($db,$_POST['zip']);
        
        //Building the query
        $sql = "UPDATE CustInfo SET Street1 = '$street1', State = '$state', Zip = '$zip' WHERE UName = '$username'";
        
        if ($db->query($sql) === TRUE) {
                $error= "Address of ". $username. " are updated successfully";
        } else {
            $error=  $sql . "<br>" . $db->error;
        }
    }
    $db->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | User Address</title>
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
                        <h1>UTEP | Auto Store</h1>
                        <h2>Customer Address</h2>
                  </div>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                <center><p style="color:#009966"><?php echo $error; ?></p></center>
                  <form id="register-form" method="POST">
                    <div class="login">
                    <input type="text" placeholder="Username" name="username">
                    <input type="text" placeholder="Street 1" name="street1">
                    <input type="text" placeholder="Street 2" name="street2">
                    <input type="text" placeholder="State" name="state">
                    <input type="text" placeholder="Zip Code" name="zip">
                    <input type="submit" value="Submit">
                    </div>
                </center>
                <center>
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
