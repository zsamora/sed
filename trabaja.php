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
<h2> Trabajos </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<thead>
			<tr>
				<th>Agregar</th>
        <th>ID</th>
				<th>Usuario</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Cargo</th>
				<th>Ciclo</th>
				<th>Asignatura</th>
			</tr>
		</thead>
		<tbody>
      <?php
      $usuarios = "SELECT DISTINCT usuarios.id as u_id,
                          usuarios.username as u_user,
                          usuarios.nombre as u_nombre,
                          usuarios.apellidop as u_ap,
                          usuarios.apellidom as u_am
                   	 FROM usuarios
                    WHERE id != 1 and id != 0
								 ORDER BY u_id";
      $usuarios_result = $conn->query($usuarios) or die("database error:". $conn->error);
      while($fila_usuarios = $usuarios_result->fetch_assoc()) { ?>
				<tr>
				<form action="agregar2.php" method="post">
        <td>
  				<div class="btn-group">
  						<button type="submit" class="btn btn-success">
  							<span class="glyphicon glyphicon-plus-sign"></span>
  						</button>
  				</div>
        </td>
        <?php echo "<input type='hidden' name='id_form' value='".$fila_usuarios["u_id"]."'><td>" . $fila_usuarios["u_id"] . "</td></input>";
              echo "<td>" . $fila_usuarios["u_user"] . "</td>";
              echo "<td>" . $fila_usuarios["u_nombre"] . "</td>";
              echo "<td>" . $fila_usuarios["u_ap"] . " " . $fila_usuarios["u_am"] . "</td>";
        ?>
        <?php
        $cargos = "SELECT cargos.id as id, cargos.nombre as nombre
                   FROM cargos";
        $cargos_result = $conn->query($cargos) or die("database error:". $conn->error); ?>
        <td>
          <select name='cargo_form' class="custom-select mb-2 mr-sm-2 mb-sm-0">
              <?php while($fila_cargos = $cargos_result->fetch_assoc()) {
                echo "<option value=".$fila_cargos[id].">".$fila_cargos[nombre]."</option>";
              } ?>
            </select>
        </td>
        <?php
        $ciclos = "SELECT ciclos.id as id, ciclos.nombre as nombre
                   FROM ciclos";
        $ciclos_result = $conn->query($ciclos) or die("database error:". $conn->error); ?>
        <td>
          <select name='ciclo_form' class="custom-select mb-2 mr-sm-2 mb-sm-0">
              <?php while($fila_ciclos = $ciclos_result->fetch_assoc()) {
                echo "<option value=".$fila_ciclos[id].">".$fila_ciclos[nombre]."</option>";
              } ?>
            </select>
        </td>
        <?php
        $asignaturas = "SELECT asignaturas.id as id, asignaturas.nombre as nombre
                        FROM asignaturas";
        $asignaturas_result = $conn->query($asignaturas) or die("database error:". $conn->error); ?>
        <td>
          <select name='asig_form' class="custom-select mb-2 mr-sm-2 mb-sm-0">
              <?php while($fila_asignaturas = $asignaturas_result->fetch_assoc()) {
                echo "<option value=".$fila_asignaturas[id].">".$fila_asignaturas[nombre]."</option>";
              } ?>
            </select>
        </td>
				</form>
				</tr>
				<?php } ?>
      </tbody>
    </table>
  </div>
	<br>
	<div class="table-responsive">
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>Acciones</th>
	        <th>ID</th>
	        <th>Usuario</th>
	        <th>Nombre</th>
	        <th>Apellidos</th>
	        <th>Perfil</th>
	        <th>Cargo</th>
	        <th>Ciclo</th>
	        <th>Asignatura</th>
					<th>Establecimiento</th>
	      </tr>
	    </thead>
	    <tbody>
	  	     <?php
	         $usuarios = "SELECT usuarios.id as u_id,
	                             usuarios.username as u_user,
	                             usuarios.nombre as u_nombre,
	                             usuarios.apellidop as u_ap,
	                             usuarios.apellidom as u_am,
	                             perfiles.nombre as p_nombre,
															 cargos.id as ca_id,
	                             cargos.nombre as ca_nombre,
															 ciclos.id as ci_id,
	                             ciclos.nombre as ci_nombre,
															 asignaturas.id as a_id,
	                             asignaturas.nombre as a_nombre,
	                             establecimiento.nombre as e_nombre
	                      FROM usuarios, trabaja, perfiles,
	                           cargos, ciclos, asignaturas, establecimiento
	                      WHERE usuarios.id = trabaja.usuario_id
	                      AND perfiles.id = trabaja.perfil_id
	                      AND cargos.id = trabaja.cargo_id
	                      AND ciclos.id = trabaja.ciclo_id
	                      AND asignaturas.id = trabaja.asignatura_id
	                      AND establecimiento.id = trabaja.establecimiento_id
												AND usuarios.id != 1 and usuarios.id != 0
									 ORDER BY u_id";
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
										 <?php echo "<li><a href='eliminar2.php?id_el=" . $fila_usuarios["u_id"].
										 																		 "&ca_el=" . $fila_usuarios["ca_id"].
																								 			 	 "&ci_el=" . $fila_usuarios["ci_id"].
																									 		   "&as_el=" . $fila_usuarios["a_id"]."'>Eliminar</a></li>"?>
	                 </ul>
									 </ul>
	               </div>
	             </td>
	         <?php
	  			    echo "<td>" . $fila_usuarios["u_id"] . "</td>";
	            echo "<td>" . $fila_usuarios["u_user"] . "</td>";
	            echo "<td>" . $fila_usuarios["u_nombre"] . "</td>";
	            echo "<td>" . $fila_usuarios["u_ap"] . " " . $fila_usuarios["u_am"] . "</td>";
	            echo "<td>" . $fila_usuarios["p_nombre"] . "</td>";
	            echo "<td>" . $fila_usuarios["ca_nombre"] . "</td>";
	            echo "<td>" . $fila_usuarios["ci_nombre"] . "</td>";
	            echo "<td>" . $fila_usuarios["a_nombre"] . "</td>";
	            echo "<td>" . $fila_usuarios["e_nombre"] . "</td>";
	            echo "</tr>";
	  		   }?>
	    </tbody>
	  </table>
	</div>
</div>
