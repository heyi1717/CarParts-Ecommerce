<?php
   //Specify the Database server host
   define('DB_SERVER', 'earth.cs.utep.edu');
   //Specify the Database username
   define('DB_USERNAME', 'hliu2');
   //Specify the Database password
   define('DB_PASSWORD', 'cs5339!hliu2');
   //Choose the Database(name)
   define('DB_DATABASE', 'f17cs4339team11');
   //We make the connection.
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
