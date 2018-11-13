<?php
include_once("db_connect.php");
$descripcion=$_POST["descripcion"];
$minimo=$_POST["minimo"];
$en_desarrollo=$_POST["en_desarrollo"];
$desarrollado=$_POST["desarrollado"];
$superior=$_POST["superior"];
$ponderacion=$_POST["ponderacion"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$agregar = "INSERT INTO criterios (`descripcion`,`minimo`,`en_desarrollo`,`desarrollado`,`superior`,`ponderacion`)
                          VALUES('$descripcion','$minimo','$en_desarrollo','$desarrollado','$superior',$ponderacion)";
if ($conn->query($agregar) === TRUE) {
  header("Location: criterios.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
