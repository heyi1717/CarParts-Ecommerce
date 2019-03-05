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
        <li role="presentation"><a href="deleteUser.php">Delete User</a></li>
        <li role="presentation"><a href="userpw.php">User Password</a></li>
        <li role="presentation"><a href="modAddress.php">User Address</a></li>
        <li role="presentation"><a href="carParts.php">Car Parts</a></li>
        <li role="presentation"><a href="admin.php">|</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div style="padding:20px;margin-top:30px;background-color:#FFFFFF;height:600px;">
    <div class="jumbotron">
        <div class="container">
<?php
    
    $user_check = $_SESSION['userName'];
    $query="SELECT * From CustInfo JOIN Users WHERE CustInfo.UName = Users.UName";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die('Could not query: '. mysqli_error());
    }
    echo "<b>Signed in As: </b>" .$user_check ."<br>"."<br>";
    ?>
            <h2>List of Users with Address</h2>
<?php
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($result)) {
            echo "<b>Username:</b> " . $row["UName"]."  |  <b>Address:</b> " . $row["Street1"].", ".$row["State"].", ".$row["Zip"]."  |  <b>First Name:</b> " . $row["Fname"]. "  |  <b>Last Name:</b> " . $row["LNAME"].  "  |  <b>User Type:</b> " . $row["Type"]."<br>".  "<b>Email:</b> " . $row["Email"]."  |  <b>Password:</b> ".$row["Password"]."  |  <b>Time of Account Creation:</b> " . $row["CreateTime"]. "  |  <b>Time of last login:</b> " . $row["LastLogin"]. "<br>"."<br>";
        }
    } else {
        echo "0 results";
    }
?>
<h2>List of All Users</h2>
<?php
    $sql = "Select * from Users";
    $info=mysqli_query($db, $sql);
    
    if (mysqli_num_rows($info) > 0) {
        // output data of each row
        while($row = mysqli_fetch_array($info)) {
            echo "<b>Username:</b> " . $row["UName"]."  |  <b>First Name:</b> " . $row["Fname"]. "  |  <b>Last Name:</b> " . $row["LNAME"]. "  |  <b>Password:</b> ".$row["Password"]. "  |  <b>User Type:</b> " . $row["Type"]."<br>".  "<b>Email:</b> " . $row["Email"]."  |  <b>Time of Account Creation:</b> " . $row["CreateTime"]. "  |  <b>Time of last login:</b> " . $row["LastLogin"]. "<br>"."<br>";
        }
    } else {
        echo "0 results";
    }
    ?>
        </div>
    </div>
</div>

</body>
</html>
