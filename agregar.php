<?php
include_once("db_connect.php");
//PUEDE ARREGLARSE LA INYECCIón AQUI
$user=$_POST["user_form"];
$pass=$_POST["pass_form"];
$rut=$_POST["rut_form"];
$nombre=$_POST["nombre_form"];
$app=$_POST["app_form"];
$apm=$_POST["apm_form"];
$email=$_POST["email_form"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO usuarios (`username`, `password`, `rut`, `nombre`, `apellidop`, `apellidom`, `email`)
                          VALUES ('$user', '$pass', '$rut', '$nombre', '$app', '$apm', '$email')";
if ($conn->query($agregar) === TRUE) {
  header("Location: usuarios.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
