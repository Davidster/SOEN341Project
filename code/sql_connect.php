<?php
define('DB_USER','sql9157076');
define('DB_PASSWORD','JpMuHUDgxv');
define('DB_HOST','sql9.freemysqlhosting.net');
define('DB_NAME','sql9157076');

//connect to database
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
OR die('Could not connect to MySQL Database'. mysqli_connect_error());

?>