<?php
session_start();
$_SESSION['proceso_id'] = $_GET['proceso_id'];
if($_SESSION['id']!=1 && $_SESSION['id']!=0){
	header("Location: index.php");
}
if(!isset($_SESSION['proceso_id'])){
	header("Location: welcome.php");
}
include('header.php');
include_once("db_connect.php");
include('navbar.php');
$proceso = $_SESSION['proceso_id'];
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
<h2>Informes</h2>
</div>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
      <tr>
				<th>Evaluado</th>
				<th>Perfil</th>
        <th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
				<th>Informe</th>
      </tr>
    </thead>
		<tbody>
			<?php
			$users = "SELECT *
									FROM trabaja
									WHERE usuario_id != 1 and usuario_id != 0";
			$user_result = $conn->query($users) or die("database error:". $conn->error);
			while($fila_user = $user_result->fetch_assoc()){
					$usuario_id = $fila_user['usuario_id'];
					$perfil_id = $fila_user['perfil_id'];
					$cargo_id = $fila_user['cargo_id'];
					$ciclo_id = $fila_user['ciclo_id'];
					$asignatura_id = $fila_user['asignatura_id'];
					$num_evalind = "SELECT COUNT(*) as res
														FROM evaluaciones_ind
													 WHERE evaluado_id = $usuario_id
													 	 AND cargo_id = $cargo_id
													   AND ciclo_id = $ciclo_id
														 AND asignatura_id = $asignatura_id";
					$num_evalcomp = "SELECT COUNT(*) as res
														FROM evaluaciones_comp
													 WHERE evaluado_id = $usuario_id
 													 	 AND cargo_id = $cargo_id
													   AND ciclo_id = $ciclo_id
														 AND asignatura_id = $asignatura_id";
					$res_eind = $conn->query($num_evalind) or die("database error:". $conn->error);
					$res_ecomp = $conn->query($num_evalcomp) or die("database error:". $conn->error);
					$row_eind = $res_eind->fetch_assoc();
					$row_ecomp = $res_ecomp->fetch_assoc();
					if ($row_eind['res'] != 0 || $row_ecomp['res'] != 0){
						$nombre = "SELECT nombre, apellidop
												 FROM usuarios
												WHERE id = $usuario_id";
						$nombre_result = $conn->query($nombre) or die("database error:". $conn->error);
						$nombre_row = $nombre_result->fetch_assoc();
						$perfil = "SELECT nombre
												 FROM perfiles
												 WHERE id = $perfil_id";
						$perfil_result = $conn->query($perfil) or die("database error:". $conn->error);
						$perfil_row = $perfil_result->fetch_assoc();
						$cargo = "SELECT nombre
												FROM cargos
											 WHERE id = $cargo_id";
						$cargo_result = $conn->query($cargo) or die("database error:". $conn->error);
						$cargo_row = $cargo_result->fetch_assoc();
						$ciclo = "SELECT nombre
												FROM ciclos
											 WHERE id = $ciclo_id";
						$ciclo_result = $conn->query($ciclo) or die("database error:". $conn->error);
						$ciclo_row = $ciclo_result->fetch_assoc();
						$asignatura = "SELECT nombre
													 FROM asignaturas
													 WHERE id = $asignatura_id";
						$asignatura_result = $conn->query($asignatura) or die("database error:". $conn->error);
						$asignatura_row = $asignatura_result->fetch_assoc();
						echo "<tr>";
						echo "<td>".$nombre_row['nombre']." ".$nombre_row['apellidop']."</td>";
						echo "<td>".$perfil_row['nombre']."</td>";
						echo "<td>".$cargo_row['nombre']."</td>";
						echo "<td>".$ciclo_row['nombre']."</td>";
						echo "<td>".$asignatura_row['nombre']."</td>";
						echo "<td><a href='informe.php?usuario_id=".$usuario_id."
						&car_id=".$cargo_id."
						&cic_id=".$ciclo_id."
						&asi_id=".$asignatura_id."'> Resultados </a></td>";
						echo "</tr>";
					}
			} ?>
		</tbody>
	</table>
</div>
</div>
<?php include('footer.php');?>
