<?php
    include('session.php');
    ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .nav {
            font-family: sans-serif;
        }

        .jumbotron{
            text-align: center;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: #fefbf9;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #111;
        }

        .active {
            background-color: #de47ff;
        }
    </style>
</head>
<body>
<nav>
    <ul class="nav nav-pills">
        <li role="presentation" class="active"><a href="admin.php">ADMIN</a></li>
        <li role="presentation"><a href="modParts.php">Modify Car Parts</a></li>
        <li role="presentation"><a href="carParts.php">|</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>
    </ul>sa
</nav>

<div style="padding:20px;margin-top:30px;background-color:#FFFFFF;height:600px;">
    <div class="jumbotron">
        <div class="container">
<?php
    
    $user_check = $_SESSION['userName'];
    $query="SELECT * From Allparts";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die('Could not query: '. mysqli_error());
    }
    echo "<b>Signed in As: </b>" .$user_check ."<br>"."<br>";
    ?>
            <h2>List of Car Parts</h2>
<center>
<?php
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($result)) {
            echo"<table>";
            echo "<tr><td>"."<b>ID: </b>"."<b>".$row["PartID"]."</b>"." <td><b>Name: </b> "."</td><td>".$row["PartName"]."</td><td>"." <b>Price: </b> ".$row["Price"]."</td><td>"." <b>Shipping: </b> ".$row["EstShippingCost"]."</td><td>"." <b>Part#: </b> ".$row["PartNumber"]. "</td><td>"." <b>Category: </b> ".$row["Category"]."</td><td>"." <b>Weight: </b> ".$row["ShippingWeight"]."</td><td>"."'".$row["Description01"]."'</td>"."</tr><br>";
            echo "</table>";
        }
    } else {
        echo "0 results";
    }
?>
</center>
        </div>
    </div>
</div>

</body>
</html>
