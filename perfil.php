<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: index.php");
}
$_SESSION['proceso_id'] = 0; /*Proceso se hace cero cuando se ingresa al Perfil*/
include('header.php');
include_once("db_connect.php");
$usuario = $_SESSION['id'];
$usuario_info = "SELECT cargos.nombre as cargo, perfiles.nombre as perfil,
												ciclos.nombre as ciclo, asignaturas.nombre as asignatura
									FROM cargos, perfiles, ciclos, asignaturas, trabaja
									WHERE trabaja.usuario_id = $usuario
									AND cargos.id = trabaja.cargo_id
									AND perfiles.id = trabaja.perfil_id
									AND ciclos.id = trabaja.ciclo_id
									AND asignaturas.id = trabaja.asignatura_id";
$usuario_result = $conn->query($usuario_info) or die("database error:". $conn->error);
$password = "SELECT password
							 FROM usuarios
							WHERE id = $usuario";
$result = $conn->query($password) or die("database error:". $conn->error);
$fila = $result->fetch_assoc();
include('navbar.php');
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
<div class="table-responsive">
	<table class ="table">
		<thead>
			<tr>
				<th>Contraseña actual</th>
				<th>Nueva Contraseña</th>
				<th>Cambiar</th>
			</tr>
		</thead>
		<tbody>
			<form action='cambiopw.php' method="post">
			<tr>
				<?php
					echo "<td>".$fila['password']."</td>";
				 ?>
				<td>
	 				<input type="text" name="pw" class="form-control" placeholder="Contraseña nueva">
	 			</td>
				<td>
					<div class="btn-group">
						<button type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon glyphicon-pencil"></span>
						</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="table">
		<thead>
      <tr>
				<th>Nombre</th>
				<th>Apellido Paterno</th>
				<th>Usuario</th>
        <th>Cargo</th>
        <th>Perfil</th>
        <th>Ciclo</th>
				<th>Asignatura</th>
      </tr>
    </thead>
		<tbody>
		<?php while($resultado = $usuario_result->fetch_assoc()){
				echo "<tr>";
				echo "<td>". $_SESSION['nombre'] . "</td>";
		    echo "<td>" . $_SESSION['apellidop'] . "</td>";
				echo "<td>". $_SESSION['username'] . "</td>";
		    echo "<td>". $resultado['cargo'] . "</td>";
		    echo "<td>" . $resultado['perfil'] . "</td>";
				echo "<td>" . $resultado['ciclo'] . "</td>";
				echo "<td>" . $resultado['asignatura'] . "</td>";
		    echo "</tr>";
		} ?>
		</tbody>
	</table>
</div>
</div>
