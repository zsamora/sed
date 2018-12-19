<?php
// MySQL Connection
$servername = "sed.saintgasparcollege.cl";
$username = "saintgas_admin";
$password = "admsesiones2017";
$dbname = "saintgas_sesiones";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //Mysql en español
if($conn->connect_errno > 0){
     die("Imposible conectarse con la base de datos [" . $mysqli->connect_error . "]");
}
?>
