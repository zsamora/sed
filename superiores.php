<?php
session_start();
if($_SESSION['id']!=1 && $_SESSION['id']!=0){ // Poner aquí las id de quien puede tener acceso
	header("Location: index.php");
}
$_SESSION['proceso_id'] = 0; /*Proceso se hace cero cuando se ingresa a la pág de procesos*/
include('header.php');
include_once("db_connect.php");
include('navbar.php');
?>
<div class="container">
	<?php include('sessionbar.php'); ?>
</div>
<h2> Superiores </h2>
<br>
<div class="container">
<div class="table-responsive">
  <table class="table table-condensed">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Usuario (Nombre - Cargo - Ciclo - Asignatura)</th>
				<th>Superior (Nombre - Cargo - Ciclo - Asignatura)</th>
			</tr>
		</thead>
    <tbody>
			<form action="agregar3.php" method="post">
				<tr>
					<td>
						<div class="btn-group">
								<button type="submit" class="btn btn-success">
									<span class="glyphicon glyphicon-plus-sign"></span>
								</button>
						</div>
					</td>
					<td>
							<select name='usuario'>
								<?php
								$usuarios = "SELECT DISTINCT usuarios.id as u_id,
																					 	 usuarios.nombre as u_nombre,
																					 	 usuarios.apellidop as u_ap,
																						 trabaja.perfil_id as p_id,
																					 	 trabaja.cargo_id as ca_id,
																					 	 trabaja.ciclo_id as ci_id,
																					 	 trabaja.asignatura_id as a_id
													 							FROM usuarios, trabaja
													 						 WHERE id != 1 and id != 0
													 					     AND usuarios.id = trabaja.usuario_id
													 					ORDER BY u_ap";
								$usuarios_result = $conn->query($usuarios) or die("database error:". $conn->error);
								while($fila_usuarios = $usuarios_result->fetch_assoc()) {
									$id = $fila_usuarios['u_id'];
									$perfil = $fila_usuarios['p_id'];
									$cargo = $fila_usuarios['ca_id'];
									$ciclo = $fila_usuarios['ci_id'];
									$asignatura = $fila_usuarios['a_id'];
									$nombre = "SELECT usuarios.nombre as nombre,
																		usuarios.apellidop as apellido
															 FROM usuarios
															WHERE usuarios.id = $id";
									$nombre_result = $conn->query($nombre) or die("database error:". $conn->error);
									$fila_nombre = $nombre_result->fetch_assoc();
									$cargos = "SELECT cargos.nombre as nombre
															 FROM cargos
															WHERE $cargo = cargos.id";
									$cargos_result = $conn->query($cargos) or die("database error:". $conn->error);
									$fila_cargo = $cargos_result->fetch_assoc();
									$ciclos = "SELECT ciclos.nombre as nombre
															 FROM ciclos
															WHERE $ciclo = ciclos.id";
									$ciclos_result = $conn->query($ciclos) or die("database error:". $conn->error);
									$fila_ciclo = $ciclos_result->fetch_assoc();
									$asignaturas = "SELECT asignaturas.nombre as nombre
																		FROM asignaturas
																	 WHERE $asignatura = asignaturas.id";
									$asignaturas_result = $conn->query($asignaturas) or die("database error:". $conn->error);
									$fila_asig = $asignaturas_result->fetch_assoc();
								 echo "<option value='".$id."-".$perfil."-".$cargo."-".$ciclo."-".$asignatura."'>".$fila_nombre['nombre']." ".$fila_nombre['apellido']." - ".$fila_cargo['nombre']." - ".$fila_ciclo['nombre']." - ".$fila_asig['nombre']."</option>";
							 } ?>
							</select>
					</td>
					<td>
						<select name='superior'>
							<?php
							$superiores = "SELECT DISTINCT usuarios.id as u_id,
																					 usuarios.nombre as u_nombre,
																					 usuarios.apellidop as u_ap,
																					 trabaja.perfil_id as p_id,
																					 trabaja.cargo_id as ca_id,
																					 trabaja.ciclo_id as ci_id,
																					 trabaja.asignatura_id as a_id
																			FROM usuarios, trabaja
																		 WHERE id != 1 and id != 0
																			 AND usuarios.id = trabaja.usuario_id
																	ORDER BY u_ap";
							$superiores_result = $conn->query($superiores) or die("database error:". $conn->error);
							while($fila_superiores = $superiores_result->fetch_assoc()) {
								$id2 = $fila_superiores['u_id'];
								$perfil2 = $fila_superiores['p_id'];
								$cargo2 = $fila_superiores['ca_id'];
								$ciclo2 = $fila_superiores['ci_id'];
								$asignatura2 = $fila_superiores['a_id'];
								$nombre = "SELECT usuarios.nombre as nombre,
																	usuarios.apellidop as apellido
														 FROM usuarios
														WHERE usuarios.id = $id2";
								$nombre_result = $conn->query($nombre) or die("database error:". $conn->error);
								$fila_nombre = $nombre_result->fetch_assoc();
								$cargos = "SELECT cargos.nombre as nombre
														 FROM cargos
														WHERE $cargo2 = cargos.id";
								$cargos_result = $conn->query($cargos) or die("database error:". $conn->error);
								$fila_cargo = $cargos_result->fetch_assoc();
								$ciclos = "SELECT ciclos.nombre as nombre
														 FROM ciclos
														WHERE $ciclo2 = ciclos.id";
								$ciclos_result = $conn->query($ciclos) or die("database error:". $conn->error);
								$fila_ciclo = $ciclos_result->fetch_assoc();
								$asignaturas = "SELECT asignaturas.nombre as nombre
																	FROM asignaturas
																 WHERE $asignatura2 = asignaturas.id";
								$asignaturas_result = $conn->query($asignaturas) or die("database error:". $conn->error);
								$fila_asig = $asignaturas_result->fetch_assoc();
							 echo "<option class='evaluador' value='".$id2."-".$perfil2."-".$cargo2."-".$ciclo2."-".$asignatura2."'>".$fila_nombre['nombre']." ".$fila_nombre['apellido']." - ".$fila_cargo['nombre']." - ".$fila_ciclo['nombre']." - ".$fila_asig['nombre']."</option>";
						 	} ?>
							</select>
					</td>
				</tr>
			</form>
		</tbody>
  </table>
</div>
	<br>
	<div class="table-responsive">
	  <table class="table table-hover" id="editable">
	    <thead>
	      <tr>
	        <th>Acciones</th>
	        <th>Nombre</th>
					<th>Cargo </th>
					<th>Ciclo </th>
					<th>Asignatura </th>
					<th>Superior</th>
					<th>Cargo </th>
					<th>Ciclo </th>
					<th>Asignatura </th>
				</tr>
	    </thead>
	    <tbody>
	  	     <?php
	         $usuarios = "SELECT u1.id as u_id,
					 										 u1.nombre as u_nombre,
	                             u1.apellidop as u_ap,
															 superiores_id.cargo_id as u_cargo,
															 superiores_id.ciclo_id as u_ciclo,
															 superiores_id.asignatura_id as u_asig,
															 u2.id as sup_id,
															 u2.nombre as sup_nombre,
															 u2.apellidop as sup_ap,
															 superiores_id.cargo2_id as sup_cargo,
															 superiores_id.ciclo2_id as sup_ciclo,
															 superiores_id.asignatura2_id as sup_asig
	                      FROM superiores_id, usuarios u1, usuarios u2
	                      WHERE u1.id = superiores_id.usuario_id
													AND u2.id = superiores_id.superior_id
										 ORDER BY u_ap";
	         $usuarios_result = $conn->query($usuarios) or die("database error:". $conn->error);
	         while($fila_usuarios = $usuarios_result->fetch_assoc()) { ?>
	           <tr>
	             <td>
	               <div class="btn-group">
	                 <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
	                   <span class="caret"></span>
	                   <span class="sr-only">Toggle Dropdown</span>
	                 </button>
	                 <ul class="dropdown-menu" role="menu">
										 <?php
										 $id = $fila_usuarios["u_id"];
										 $cargo = $fila_usuarios["u_cargo"];
										 $ciclo = $fila_usuarios["u_ciclo"];
										 $asig = $fila_usuarios["u_asig"];
										 $sup_id = $fila_usuarios["sup_id"];
										 $sup_cargo = $fila_usuarios["sup_cargo"];
										 $sup_ciclo = $fila_usuarios["sup_ciclo"];
										 $sup_asig = $fila_usuarios["sup_asig"];
										 echo "<li><a href='eliminar3.php?id_el=" . $id.
																									 "&ca_el=" . $cargo.
																									 "&ci_el=" . $ciclo.
																									 "&as_el=" . $asig.
																									 "&id_sup=". $sup_id.
																									 "&ca_sup=" . $sup_cargo.
																									 "&ci_sup=" . $sup_ciclo.
																									 "&asig_sup=" . $sup_asig."'>Eliminar</a></li>"?>
	                 </ul>
	               </div>
	             </td>
						<?php
							$cargo = $fila_usuarios['u_cargo'];
	 						$cargos = "SELECT cargos.nombre as nombre
	 	                       FROM cargos
	 												 WHERE $cargo = cargos.id";
	 						$cargos_result = $conn->query($cargos) or die("database error:". $conn->error);
	 						$fila_cargo = $cargos_result->fetch_assoc();
							$cargo2 = $fila_usuarios['sup_cargo'];
	 						$cargos2 = "SELECT cargos.nombre as nombre
	 	                       FROM cargos
	 												 WHERE $cargo2 = cargos.id";
	 						$cargos2_result = $conn->query($cargos2) or die("database error:". $conn->error);
	 						$fila_cargo2 = $cargos2_result->fetch_assoc();
	 						$ciclo = $fila_usuarios['u_ciclo'];
	 						$ciclos = "SELECT ciclos.nombre as nombre
	 	                       FROM ciclos
	 												 WHERE $ciclo = ciclos.id";
	 						$ciclos_result = $conn->query($ciclos) or die("database error:". $conn->error);
	 						$fila_ciclo = $ciclos_result->fetch_assoc();
							$ciclo2 = $fila_usuarios['sup_ciclo'];
	 						$ciclos2 = "SELECT ciclos.nombre as nombre
	 	                       FROM ciclos
	 												 WHERE $ciclo2 = ciclos.id";
	 						$ciclos2_result = $conn->query($ciclos2) or die("database error:". $conn->error);
	 						$fila_ciclo2 = $ciclos2_result->fetch_assoc();
	 						$asig = $fila_usuarios['u_asig'];
	 						$asignaturas = "SELECT asignaturas.nombre as nombre
	 	                       FROM asignaturas
	 												 WHERE $asig = asignaturas.id";
	 						$asignaturas_result = $conn->query($asignaturas) or die("database error:". $conn->error);
	 						$fila_asig = $asignaturas_result->fetch_assoc();
							$asig2 = $fila_usuarios['sup_asig'];
	 						$asignaturas2 = "SELECT asignaturas.nombre as nombre
	 	                       FROM asignaturas
	 												 WHERE $asig2 = asignaturas.id";
	 						$asignaturas2_result = $conn->query($asignaturas2) or die("database error:". $conn->error);
	 						$fila_asig2 = $asignaturas2_result->fetch_assoc();
	  			    echo "<td name='id_form'>" . $fila_usuarios["u_nombre"] ." ". $fila_usuarios["u_ap"] . "</td>";
							echo "<td name='user_form'>" . $fila_cargo["nombre"] . "</td>";
							echo "<td name='user_form'>" . $fila_ciclo["nombre"] . "</td>";
							echo "<td name='user_form'>" . $fila_asig["nombre"] . "</td>";
	            echo "<td name='pass_form'>" . $fila_usuarios["sup_nombre"] ." ". $fila_usuarios["sup_ap"] . "</td>";
							echo "<td name='user_form'>" . $fila_cargo2["nombre"] . "</td>";
							echo "<td name='user_form'>" . $fila_ciclo2["nombre"] . "</td>";
							echo "<td name='user_form'>" . $fila_asig2["nombre"] . "</td>";
	            echo "</tr>";
	  		   }?>
	    </tbody>
	  </table>
	</div>
</div>
<?php include('footer.php');?>
