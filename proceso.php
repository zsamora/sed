<?php
session_start();
$_SESSION['proceso_id'] = $_GET['proceso_id'];
if(!isset($_SESSION['id'])){
	header("Location: index.php");
}
if(!isset($_SESSION['proceso_id'])){
	header("Location: welcome.php");
}
$proceso=$_SESSION['proceso_id'];
$evaluador=$_SESSION['id'];
/* Saltar a resultados si es admin */
if($_SESSION['id'] == 1 or $_SESSION['id'] == 0) {
	header("Location: resultados.php?proceso_id=".$proceso);
}
include('header.php');
include_once("db_connect.php");
// Evaluaciones Indicadores (Seleccionan las id y cargos respectivos distintos para ser evaluados)
$eval_ind = "SELECT DISTINCT tipo_id,evaluado_id, cargo_id, ciclo_id, asignatura_id, evaluador_id, cargo_sup, ciclo_sup, asignatura_sup, estado
						 FROM evaluaciones_ind
						 WHERE proceso_id = $proceso
						 AND evaluador_id = $evaluador";
$evalind_result = $conn->query($eval_ind) or die("database error:". $conn->error);
// Evaluaciones Competencias (Seleccionan las id y cargos respectivos distintos para ser evaluados)
$eval_comp = "SELECT DISTINCT tipo_id, evaluado_id, cargo_id, ciclo_id, asignatura_id, evaluador_id, cargo_sup, ciclo_sup, asignatura_sup, estado
						  FROM evaluaciones_comp
							WHERE proceso_id = $proceso
							AND evaluador_id = $evaluador";
$evalcomp_result = $conn->query($eval_comp) or die("database error:". $conn->error);
include('navbar.php');
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
<div class="table-responsive">
	<h2> Evaluaciones de Metas e Indicadores </h2>
	<table class="table">
		<thead>
      <tr>
				<th>Tipo de Evaluación</th>
        <th>Evaluado</th>
				<th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
        <th>Evaluador</th>
				<th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
				<th>Estado </th>
      </tr>
    </thead>
		<tbody>
<?php while($fila_ind = $evalind_result->fetch_assoc()){
		// Nombre evaluado
		$evaluado_id = $fila_ind['evaluado_id'];
		$evaluado_nombre = "SELECT nombre, apellidop
												FROM usuarios
												WHERE id = $evaluado_id";
		$nombre_res = $conn->query($evaluado_nombre) or die("database error:". $conn->error);
		$nombre_row = $nombre_res->fetch_assoc();
		// Cargos Evaluado y Evaluador
		$evaluado_cargo = $fila_ind['cargo_id'];
		$evaluador_cargo = $fila_ind['cargo_sup'];
		$cargos = "SELECT c1.nombre as cargo1, c2.nombre as cargo2
							 FROM cargos c1, cargos c2
							 WHERE c1.id = $evaluado_cargo
							 AND c2.id = $evaluador_cargo";
		$cargo_res = $conn->query($cargos) or die("database error:". $conn->error);
		$cargo_row = $cargo_res->fetch_assoc();
		// Ciclos Evaluado y Evaluador
		$evaluado_ciclo = $fila_ind['ciclo_id'];
		$evaluador_ciclo = $fila_ind['ciclo_sup'];
		$ciclos = "SELECT c1.nombre as ciclo1, c2.nombre as ciclo2
							 FROM ciclos c1, ciclos c2
							 WHERE c1.id = $evaluado_ciclo
							 AND c2.id = $evaluador_ciclo";
		$ciclo_res = $conn->query($ciclos) or die("database error:". $conn->error);
		$ciclo_row = $ciclo_res->fetch_assoc();
		$evaluado_asignatura = $fila_ind['asignatura_id'];
		$evaluador_asignatura = $fila_ind['asignatura_sup'];
		$asignaturas = "SELECT a1.nombre as asignatura1, a2.nombre as asignatura2
							 FROM asignaturas a1, asignaturas a2
							 WHERE a1.id = $evaluado_asignatura
							 AND a2.id = $evaluador_asignatura";
		$asignatura_res = $conn->query($asignaturas) or die("database error:". $conn->error);
		$asignatura_row = $asignatura_res->fetch_assoc();
		$evaluado_id = $fila_ind['evaluado_id'];
		$tipo_eval = $fila_ind["tipo_id"];
		$tipo = "SELECT nombre
							 FROM evaluacion_tipo
							 WHERE id = $tipo_eval";
		$tipo_res = $conn->query($tipo) or die("database error:". $conn->error);
		$tipo_row = $tipo_res->fetch_assoc();
		$neval = "SELECT COUNT(*) as res
							  FROM evaluaciones_ind
							 WHERE tipo_id = $tipo_eval
							 	 AND evaluado_id = $evaluado_id
								 AND cargo_id = $evaluado_cargo
								 AND ciclo_id = $evaluado_ciclo
								 AND asignatura_id = $evaluado_asignatura
								 AND evaluador_id = $evaluador
								 AND cargo_sup = $evaluador_cargo
								 AND ciclo_sup = $evaluador_ciclo
								 AND asignatura_sup = $evaluador_asignatura
								 AND estado = 1";
		$neval_res = $conn->query($neval) or die("database error:". $conn->error);
		$neval_row = $neval_res->fetch_assoc();
		$nresp = "SELECT COUNT(*) as res
								FROM resultados_ind
							 WHERE evaluacion_id
							 		IN (SELECT id
												FROM evaluaciones_ind
											 WHERE tipo_id = $tipo_eval
												 AND evaluado_id = $evaluado_id
												 AND cargo_id = $evaluado_cargo
												 AND ciclo_id = $evaluado_ciclo
												 AND asignatura_id = $evaluado_asignatura
												 AND evaluador_id = $evaluador
												 AND cargo_sup = $evaluador_cargo
												 AND ciclo_sup = $evaluador_ciclo
												 AND asignatura_sup = $evaluador_asignatura)";
		$nresp_res = $conn->query($nresp) or die("database error:". $conn->error);
		$nresp_row = $nresp_res->fetch_assoc();
		// Aca se puede agregar una query que modifique el valor de los respondidos
		//echo " eval: ".$neval_row['res']." -  resp: ". $nresp_row['res']. " - ";
		echo "<tr>";
		echo "<td>". $tipo_row["nombre"] . "</td>";
		echo "<td>" . $nombre_row["nombre"] . " " . $nombre_row["apellidop"] . "</td>";
		echo "<td>" . $cargo_row['cargo1']. "</td>";
		echo "<td>" . $ciclo_row["ciclo1"] . "</td>";
		echo "<td>" . $asignatura_row["asignatura1"]  . "</td>";
		echo "<td>" . $_SESSION["nombre"] . " " . $_SESSION["apellidop"] ." (yo) </td>";
		echo "<td>" . $cargo_row["cargo2"] . "</td>";
		echo "<td>" . $ciclo_row["ciclo2"] . "</td>";
		echo "<td>" . $asignatura_row["asignatura2"]  . "</td>";
		if ($neval_row['res'] == 0){
			echo "<td> No Disponible </td>";
		}
		else if ($nresp_row['res']==$neval_row['res']){
			echo "<td> <a href='evaluacionind.php?
				eval_id=".$fila_ind['evaluado_id']."
				&car_id=".$fila_ind['cargo_id']."
				&cic_id=".$fila_ind['ciclo_id']."
				&asi_id=".$fila_ind['asignatura_id']."
				&car2_id=".$fila_ind['cargo_sup']."
				&cic2_id=".$fila_ind['ciclo_sup']."
				&asi2_id=".$fila_ind['asignatura_sup']."
				&tipo_eval=".$fila_ind['tipo_id']."
				'> Terminada </a></td>";
		}
		else if ($nresp_row['res']==0){
			echo "<td> <a href='evaluacionind.php?
				eval_id=".$fila_ind['evaluado_id']."
				&car_id=".$fila_ind['cargo_id']."
				&cic_id=".$fila_ind['ciclo_id']."
				&asi_id=".$fila_ind['asignatura_id']."
				&car2_id=".$fila_ind['cargo_sup']."
				&cic2_id=".$fila_ind['ciclo_sup']."
				&asi2_id=".$fila_ind['asignatura_sup']."
				&tipo_eval=".$fila_ind['tipo_id']."
				'> No Iniciada </a></td>";
		}
		else if ($nresp_row['res'] <= $neval_row['res']){
			echo "<td> <a href='evaluacionind.php?
				eval_id=".$fila_ind['evaluado_id']."
				&car_id=".$fila_ind['cargo_id']."
				&cic_id=".$fila_ind['ciclo_id']."
				&asi_id=".$fila_ind['asignatura_id']."
				&car2_id=".$fila_ind['cargo_sup']."
				&cic2_id=".$fila_ind['ciclo_sup']."
				&asi2_id=".$fila_ind['asignatura_sup']."
				&tipo_eval=".$fila_ind['tipo_id']."
				'> Pendiente </a></td>";
		}
    echo "</tr>";
} ?>
		</tbody>
	</table>
</div>
<div class="table-responsive">
	<h2> Evaluaciones de Competencia </h2>
	<table class="table">
		<thead>
      <tr>
				<th>Tipo de Evaluación</th>
        <th>Evaluado</th>
				<th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
        <th>Evaluador</th>
				<th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
				<th>Estado </th>
      </tr>
    </thead>
		<tbody>
<?php while($fila_comp = $evalcomp_result->fetch_assoc()){
		// Nombre evaluado
		$evaluado_id = $fila_comp['evaluado_id'];
		$evaluado_nombre = "SELECT nombre, apellidop
												FROM usuarios
												WHERE id = $evaluado_id";
		$res = $conn->query($evaluado_nombre) or die("database error:". $conn->error);
		$row = $res->fetch_assoc();
		// Cargos Evaluado y Evaluador
		$evaluado_cargo = $fila_comp['cargo_id'];
		$evaluador_cargo = $fila_comp['cargo_sup'];
		$cargos = "SELECT c1.nombre as cargo1, c2.nombre as cargo2
							 FROM cargos c1, cargos c2
							 WHERE c1.id = $evaluado_cargo
							 AND c2.id = $evaluador_cargo";
		$cargo_res = $conn->query($cargos) or die("database error:". $conn->error);
		$cargo_row = $cargo_res->fetch_assoc();
		// Ciclos Evaluado y Evaluador
		$evaluado_ciclo = $fila_comp['ciclo_id'];
		$evaluador_ciclo = $fila_comp['ciclo_sup'];
		$ciclos = "SELECT c1.nombre as ciclo1, c2.nombre as ciclo2
							 FROM ciclos c1, ciclos c2
							 WHERE c1.id = $evaluado_ciclo
							 AND c2.id = $evaluador_ciclo";
		$ciclo_res = $conn->query($ciclos) or die("database error:". $conn->error);
		$ciclo_row = $ciclo_res->fetch_assoc();
		$evaluado_asignatura = $fila_comp['asignatura_id'];
		$evaluador_asignatura = $fila_comp['asignatura_sup'];
		$asignaturas = "SELECT a1.nombre as asignatura1, a2.nombre as asignatura2
							 				FROM asignaturas a1, asignaturas a2
							 			 WHERE a1.id = $evaluado_asignatura
							 		 		 AND a2.id = $evaluador_asignatura";
		$asignatura_res = $conn->query($asignaturas) or die("database error:". $conn->error);
		$asignatura_row = $asignatura_res->fetch_assoc();
		$tipo_eval = $fila_comp["tipo_id"];
		$tipo = "SELECT nombre
							 FROM evaluacion_tipo
							 WHERE id = $tipo_eval";
		$tipo_res = $conn->query($tipo) or die("database error:". $conn->error);
		$tipo_row = $tipo_res->fetch_assoc();
		$neval = "SELECT COUNT(*) as res
							  FROM evaluaciones_comp
							 WHERE tipo_id = $tipo_eval
							 	 AND evaluado_id = $evaluado_id
								 AND cargo_id = $evaluado_cargo
								 AND ciclo_id = $evaluado_ciclo
								 AND asignatura_id = $evaluado_asignatura
								 AND evaluador_id = $evaluador
								 AND cargo_sup = $evaluador_cargo
								 AND ciclo_sup = $evaluador_ciclo
								 AND asignatura_sup = $evaluador_asignatura
								 AND estado = 1";
		$neval_res = $conn->query($neval) or die("database error:". $conn->error);
		$neval_row = $neval_res->fetch_assoc();
		$nresp = "SELECT COUNT(*) as res
								FROM resultados_comp
							 WHERE evaluacion_id
							 		IN (SELECT id
												FROM evaluaciones_comp
											 WHERE tipo_id = $tipo_eval
												 AND evaluado_id = $evaluado_id
												 AND cargo_id = $evaluado_cargo
												 AND ciclo_id = $evaluado_ciclo
												 AND asignatura_id = $evaluado_asignatura
												 AND evaluador_id = $evaluador
												 AND cargo_sup = $evaluador_cargo
												 AND ciclo_sup = $evaluador_ciclo
												 AND asignatura_sup = $evaluador_asignatura)";
		$nresp_res = $conn->query($nresp) or die("database error:". $conn->error);
		$nresp_row = $nresp_res->fetch_assoc();
		//echo " eval: ".$neval_row['res']." -  resp: ". $nresp_row['res']. " - ";
		echo "<tr>";
		echo "<td>". $tipo_row["nombre"] . "</td>";
    echo "<td>" . $row["nombre"] . " " . $row["apellidop"] . "</td>";
		echo "<td>" . $cargo_row['cargo1']. "</td>";
		echo "<td>" . $ciclo_row["ciclo1"] . "</td>";
		echo "<td>" . $asignatura_row["asignatura1"]  . "</td>";
		echo "<td>" . $_SESSION["nombre"] . " " . $_SESSION["apellidop"] ." (yo) </td>";
		echo "<td>" . $cargo_row["cargo2"] . "</td>";
		echo "<td>" . $ciclo_row["ciclo2"] . "</td>";
		echo "<td>" . $asignatura_row["asignatura2"]  . "</td>";
		if ($neval_row['res'] == 0){
			echo "<td> No Disponible </td>";
		}
		else if ($nresp_row['res']==$neval_row['res']){
			echo "<td> <a href='evaluacioncomp.php?
				eval_id=".$fila_comp['evaluado_id']."
				&car_id=".$fila_comp['cargo_id']."
				&cic_id=".$fila_comp['ciclo_id']."
				&asi_id=".$fila_comp['asignatura_id']."
				&car2_id=".$fila_comp['cargo_sup']."
				&cic2_id=".$fila_comp['ciclo_sup']."
				&asi2_id=".$fila_comp['asignatura_sup']."
				&tipo_eval=".$fila_comp['tipo_id']."
				'> Terminada </a></td>";
		}
		else if ($nresp_row['res']==0) {
			echo "<td> <a href='evaluacioncomp.php?
						eval_id=".$fila_comp['evaluado_id']."
						&car_id=".$fila_comp['cargo_id']."
						&cic_id=".$fila_comp['ciclo_id']."
						&asi_id=".$fila_comp['asignatura_id']."
						&car2_id=".$fila_comp['cargo_sup']."
						&cic2_id=".$fila_comp['ciclo_sup']."
						&asi2_id=".$fila_comp['asignatura_sup']."
						&tipo_eval=".$fila_comp['tipo_id']."
					'> No Iniciado </a></td>";
		}
		else if ($nresp_row['res'] <= $neval_row['res']){
			echo "<td> <a href='evaluacioncomp.php?
						eval_id=".$fila_comp['evaluado_id']."
						&car_id=".$fila_comp['cargo_id']."
						&cic_id=".$fila_comp['ciclo_id']."
						&asi_id=".$fila_comp['asignatura_id']."
						&car2_id=".$fila_comp['cargo_sup']."
						&cic2_id=".$fila_comp['ciclo_sup']."
						&asi2_id=".$fila_comp['asignatura_sup']."
						&tipo_eval=".$fila_comp['tipo_id']."
					'> Pendiente </a></td>";
		}
    echo "</tr>";
		} ?>
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
