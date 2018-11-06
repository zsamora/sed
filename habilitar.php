<?php
include_once("db_connect.php");
$usuario=$_GET["id"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$habilitar = "UPDATE usuarios
                 SET habilitado = 1
               WHERE id = $usuario";
//
$habilitar_ecomp = "UPDATE evaluaciones_comp
                 SET estado = 1
               WHERE evaluado_id = $usuario
               OR evaluador_id = $usuario";
$habilitar_eind = "UPDATE evaluaciones_ind
                 SET estado = 1
               WHERE evaluado_id = $usuario
               OR evaluador_id = $usuario";
if ($conn->query($habilitar) && $conn->query($habilitar_ecomp) &&
    $conn->query($habilitar_eind)) {
  header("Location: usuarios.php");
} else {
    echo "Error: " . $habilitar . "<br>" . $conn->error;
}
die();
?>
