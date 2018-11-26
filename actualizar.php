<?php
include_once("db_connect.php");
$id=$_GET["id_el"];
//TODO: ARREGLAR INYECCIONES Y ENVIAR MENSAJE DE SUCCESS, Y ARREGLAR ESTABLECIMIENTO
$evalcomp = "DELETE FROM evaluaciones_comp
									 WHERE proceso_id = $id";
$evalind = "DELETE FROM evaluaciones_ind
									WHERE proceso_id = $id";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
// Demora demasiado
/*while ($fila = $evalcomp_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalcomp = "DELETE FROM evaluaciones_comp WHERE id = $id";
	$eliminar_evalcomp_result = $conn->query($eliminar_evalcomp) or die ("database error:".$conn->error);
  $eliminar_rescomp = "DELETE FROM resultados_comp WHERE evaluacion_id = $id";
	$eliminar_rescomp_result = $conn->query($eliminar_rescomp) or die ("database error:".$conn->error);
}
while ($fila = $evalind_result->fetch_assoc()){
	$id = $fila['id'];
	$eliminar_evalind = "DELETE FROM evaluaciones_ind WHERE id = $id";
	$eliminar_evalind_result = $conn->query($eliminar_evalind) or die ("database error:".$conn->error);
  $eliminar_resind = "DELETE FROM resultados_ind WHERE evaluacion_id = $id";
	$eliminar_resind_result = $conn->query($eliminar_resind) or die ("database error:".$conn->error);
}*/
$evalind = "INSERT INTO `evaluaciones_ind`(`tipo_id`, `meta_id`,`indicador_id`, `evaluado_id`, `cargo_id`,
                        `ciclo_id`, `asignatura_id`, `evaluador_id`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`,`proceso_id`)
                 SELECT 2, indicadores.meta_id, indicadores.id, opinantes.evaluado_id,
                        opinantes.cargo_id, opinantes.ciclo_id, opinantes.asignatura_id, opinantes.evaluador_id,
                        opinantes.cargo_sup, opinantes.ciclo_sup, opinantes.asignatura_sup, $id
                   FROM indicador_cargos, indicadores, opinantes, proc_ind
                  WHERE indicador_cargos.cargo_id = opinantes.cargo_id
                    AND opinantes.tipo_id = 2
                    AND indicadores.id = indicador_cargos.indicador_id
                    AND proc_ind.proceso_id = $id
                    AND indicador_cargos.indicador_id = proc_ind.indicador_id";
/*AUTOEVAL*/
$evalcomp1 = "INSERT INTO `evaluaciones_comp`(`tipo_id`, `competencia_id`, `criterio_id`, `evaluado_id`,
                          `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`,`proceso_id`)
                  SELECT 1, comp_perfiles.competencia_id, comp_crit.criterio_id, opinantes.evaluado_id,
                         opinantes.cargo_id, opinantes.ciclo_id, opinantes.asignatura_id, opinantes.evaluado_id,
                         opinantes.cargo_id, opinantes.ciclo_id, opinantes.asignatura_id, $id
                    FROM comp_perfiles, comp_crit, opinantes, proc_comp
                   WHERE comp_perfiles.perfil_id = opinantes.perfil_id
                     AND opinantes.tipo_id = 1
                     AND comp_perfiles.competencia_id = comp_crit.competencia_id
                     AND proc_comp.proceso_id = $id
                     AND comp_perfiles.competencia_id = proc_comp.competencia_id";
/*SUPERIOR*/
$evalcomp2 = "INSERT INTO `evaluaciones_comp`(`tipo_id`, `competencia_id`, `criterio_id`, `evaluado_id`,
                          `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`,`proceso_id`)
                  SELECT 2, comp_perfiles.competencia_id, comp_crit.criterio_id, opinantes.evaluado_id,
                         opinantes.cargo_id, opinantes.ciclo_id, opinantes.asignatura_id, opinantes.evaluador_id,
                         opinantes.cargo_sup, opinantes.ciclo_sup, opinantes.asignatura_sup, $id
                    FROM comp_perfiles, comp_crit, opinantes, proc_comp
                   WHERE comp_perfiles.perfil_id = opinantes.perfil_id
                     AND opinantes.tipo_id = 2
                     AND comp_perfiles.competencia_id = comp_crit.competencia_id
                     AND proc_comp.proceso_id = $id
                     AND comp_perfiles.competencia_id = proc_comp.competencia_id";
/*COLAB*/
$evalcomp3 = "INSERT INTO `evaluaciones_comp`(`tipo_id`, `competencia_id`, `criterio_id`, `evaluado_id`,
                          `cargo_id`, `ciclo_id`, `asignatura_id`, `evaluador_id`, `cargo_sup`, `ciclo_sup`, `asignatura_sup`,`proceso_id`)
                  SELECT 3, comp_perfiles.competencia_id, comp_crit.criterio_id, opinantes.evaluado_id,
                         opinantes.cargo_id, opinantes.ciclo_id, opinantes.asignatura_id, opinantes.evaluador_id,
                         opinantes.cargo_sup, opinantes.ciclo_sup, opinantes.asignatura_sup, $id
                    FROM comp_perfiles, comp_crit, opinantes, proc_comp
                   WHERE comp_perfiles.perfil_id = opinantes.perfil_id
                     AND opinantes.tipo_id = 3
                     AND comp_perfiles.competencia_id = comp_crit.competencia_id
                     AND proc_comp.proceso_id = $id
                     AND comp_perfiles.competencia_id = proc_comp.competencia_id";
/*$resind = "INSERT INTO resultados_ind
								SELECT id, 0
									FROM evaluaciones_ind";
$rescomp = "INSERT INTO resultados_comp
				         SELECT id, 0
									 FROM evaluaciones_comp";*/
if ($conn->query($evalind) && $conn->query($evalcomp1) && $conn->query($evalcomp2) && $conn->query($evalcomp3)) {
	//if ($conn->query($resind) && $conn->query($rescomp)){
		header("Location: procesos.php");
	//}
}
else {
    echo "Error: " . $agregar . "<br>" . $conn->error;
}
die();
?>
