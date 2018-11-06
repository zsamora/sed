<?php
include_once("db_connect.php");
$usuario=$_GET["id"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$deshabilitar = "UPDATE usuarios
                 SET habilitado = 0
               WHERE id = $usuario";
$deshabilitar_ecomp = "UPDATE evaluaciones_comp
                 SET estado = 0
               WHERE evaluado_id = $usuario
               OR evaluador_id = $usuario";
$deshabilitar_eind = "UPDATE evaluaciones_ind
                 SET estado = 0
               WHERE evaluado_id = $usuario
               OR evaluador_id = $usuario";
if ($conn->query($deshabilitar) && $conn->query($deshabilitar_ecomp) &&
    $conn->query($deshabilitar_eind)) {
  header("Location: usuarios.php");
} else {
    echo "Error: " . $deshabilitar . "<br>" . $conn->error;
}
die();
?>
