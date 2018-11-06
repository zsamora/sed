<?php
include_once("db_connect.php");
$id=$_POST["id_form"];
$cargo=$_POST["cargo_form"];
$ciclo=$_POST["ciclo_form"];
$asig=$_POST["asig_form"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS, Y ARREGLAR ESTABLECIMIENTO
$agregar = "INSERT INTO `trabaja`(`usuario_id`, `perfil_id`, `cargo_id`, `ciclo_id`, `asignatura_id`, `establecimiento_id`)
                 SELECT $id, cargos.perfil_id, $cargo, $ciclo, $asig, 1
                   FROM cargos
                  WHERE cargos.id = $cargo";
$opinantes = "INSERT INTO `opinantes`(`tipo_id`, `evaluado_id`, `perfil_id`, `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `perfil_sup`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`)
                   SELECT 1,$id,cargos.perfil_id, $cargo, $ciclo, $asig, $id, cargos.perfil_id, $cargo, $ciclo, $asig
                     FROM cargos
                    WHERE cargos.id = $cargo";

if ($conn->query($agregar) && $conn->query($opinantes)) {
  header("Location: trabaja.php");
} else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
