<?php
include_once("db_connect.php");
$id=$_GET["id_el"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS, Y ARREGLAR ESTABLECIMIENTO
$evalcomp = "UPDATE evaluaciones_comp
                SET estado = 1
							WHERE proceso_id = $id";
$evalind = "UPDATE evaluaciones_ind
               SET estado = 1
             WHERE proceso_id = $id";
//$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
//$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
if ($conn->query($evalind) && $conn->query($evalcomp)) {
	header("Location: procesos.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
