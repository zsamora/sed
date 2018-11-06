<?php
include_once("db_connect.php");
$proceso=$_GET["id"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS
$deshabilitar = "UPDATE procesos
                 SET habilitado = 0
               WHERE id = $proceso";
$deshabilitar_ecomp = "UPDATE evaluaciones_comp
                       SET estado = 0
                     WHERE proceso_id = $proceso";
$deshabilitar_eind = "UPDATE evaluaciones_ind
                      SET estado = 0
                    WHERE proceso_id = $proceso";
if ($conn->query($deshabilitar) && $conn->query($deshabilitar_eind) &&
    $conn->query($deshabilitar_ecomp)) {
  header("Location: procesos.php");
} else {
    echo "Error: " . $deshabilitar . "<br>" . $conn->error;
}
die();
?>
