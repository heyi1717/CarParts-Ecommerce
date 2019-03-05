<?php
    include("config.php");
    include('session.php');
    $error = "";
    
    if(!$db){
        die('Could not connect: '. mysqli_error());
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $id = mysqli_real_escape_string($db,$_POST['id']);
        $name = mysqli_real_escape_string($db,$_POST['name']);
        $price = mysqli_real_escape_string($db,$_POST['price']);
        $category = mysqli_real_escape_string($db,$_POST['category']);
        $description = mysqli_real_escape_string($db,$_POST['description']);
        
        //Building the query
        $sql = "UPDATE Allparts SET PartName = '$name', Price = '$price', Category = '$category', Description01 = '$description'  WHERE PartID = '$id'";
        
        if ($db->query($sql) === TRUE) {
            $error= "Car Part ID: ". $id. " are updated successfully";
        } else {
            $error=  $sql . "<br>" . $db->error;
        }
    }
    $db->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Parts</title>
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
                        <h2>Car Parts</h2>
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
                    <input type="text" placeholder="Car Part ID" name="id">
                    <input type="text" placeholder="Part Name" name="name">
                    <input type="text" placeholder="Price" name="price">
                    <input type="text" placeholder="Category" name="category">
                    <input type="text" placeholder="Description" name="description">
                    <input type="submit" value="Submit">
                    </div>
                </center>
                <center>
                    <a href="carParts.php" class="signup">Car Parts Info Page</a>
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
