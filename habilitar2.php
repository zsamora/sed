<?php
include_once("db_connect.php");
$proceso=$_GET["id"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$habilitar = "UPDATE procesos
                 SET habilitado = 1
               WHERE id = $proceso";
$habilitar_ecomp = "UPDATE evaluaciones_comp
                       SET estado = 1
                     WHERE proceso_id = $proceso";
$habilitar_eind = "UPDATE evaluaciones_ind
                      SET estado = 1
                    WHERE proceso_id = $proceso";
if ($conn->query($habilitar) && $conn->query($habilitar_ecomp) &&
    $conn->query($habilitar_eind)) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $habilitar . "<br>" . $conn->error;
}
die();
?>
