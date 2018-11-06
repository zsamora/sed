<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
include_once("db_connect.php");
$id_el = $_GET['id_el'];
$ca_el = $_GET['ca_el'];
$ci_el = $_GET['ci_el'];
$as_el = $_GET['as_el'];
$id_sup = $_GET['id_sup'];
$ca_sup = $_GET['ca_sup'];
$ci_sup = $_GET['ci_sup'];
$asig_sup = $_GET['asig_sup'];
$eliminar = "DELETE FROM superiores_id
                   WHERE usuario_id = $id_el
                     AND cargo_id = $ca_el
                     AND ciclo_id = $ci_el
                     AND asignatura_id = $as_el
                     AND superior_id = $id_sup
                     AND cargo2_id = $ca_sup
                     AND ciclo2_id = $ci_sup
                     AND asignatura2_id = $asig_sup";
$eliminar2 = "DELETE FROM opinantes
                   WHERE evaluado_id = $id_el
									   AND cargo_id = $ca_el
									   AND ciclo_id = $ci_el
									   AND asignatura_id = $as_el
										 AND evaluador_id = $id_sup
										 AND cargo_sup = $ca_sup
										 AND ciclo_sup = $ci_sup
										 AND asignatura_sup = $asig_sup";
$eliminar3 = "DELETE FROM opinantes
										WHERE evaluado_id = $id_sup
										AND cargo_id = $ca_sup
										AND ciclo_id = $ci_sup
										AND asignatura_id = $asig_sup
										AND evaluador_id = $id_el
										AND cargo_sup = $ca_el
										AND ciclo_sup = $ci_el
										AND asignatura_sup = $as_el";
$evalcomp = "SELECT id FROM evaluaciones_comp
										WHERE evaluado_id = $id_el
											AND cargo_id = $ca_el
											AND ciclo_id = $ci_el
											AND asignatura_id = $as_el
											AND evaluador_id = $id_sup
											AND cargo_sup = $ca_sup
											AND ciclo_sup = $ci_sup
											AND asignatura_sup = $asig_sup
											OR evaluado_id = $id_sup
											AND cargo_id = $ca_sup
											AND ciclo_id = $ci_sup
											AND asignatura_id = $asig_sup
											AND evaluador_id = $id_el
											AND cargo_sup = $ca_el
											AND ciclo_sup = $ci_el
											AND asignatura_sup = $as_el";
$evalcomp_result = $conn->query($evalcomp) or die ("database error:".$conn->error);
$evalind = "SELECT id FROM evaluaciones_ind
											WHERE evaluado_id = $id_el
												AND cargo_id = $ca_el
												AND ciclo_id = $ci_el
												AND asignatura_id = $as_el
												AND evaluador_id = $id_sup
												AND cargo_sup = $ca_sup
												AND ciclo_sup = $ci_sup
												AND asignatura_sup = $asig_sup";
$evalind_result = $conn->query($evalind) or die ("database error:".$conn->error);
while ($fila = $evalcomp_result->fetch_assoc()){
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
}
$eliminar_result = $conn->query($eliminar) or die ("database error:".$conn->error);
$eliminar2_result = $conn->query($eliminar2) or die ("database error:".$conn->error);
$eliminar3_result = $conn->query($eliminar3) or die ("database error:".$conn->error);
header("Location: superiores.php");
die();
?>
