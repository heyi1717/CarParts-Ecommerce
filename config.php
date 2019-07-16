<?php
   //Specify the Database server host
   define('DB_SERVER', 'server');
   //Specify the Database username
   define('DB_USERNAME', 'username');
   //Specify the Database password
   define('DB_PASSWORD', 'pw');
   //Choose the Database(name)
   define('DB_DATABASE', 'db');
   //We make the connection.
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
