<?php
session_start();
include_once("db_connect.php");
$usuario=$_SESSION['id'];
$pass=$_POST["pw"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$cambiar = "UPDATE usuarios
               SET password = '$pass'
             WHERE id = $usuario
               AND '$pass' != '' ";
if ($conn->query($cambiar) === TRUE) {
  header("Location: perfil.php");
} else {
    echo "Error: " . $cambiar . "<br>" . $conn->error;
}
die();
?>
