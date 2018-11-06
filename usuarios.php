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
<h2> Usuarios </h2>
<br>
<div class="container">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Agregar</th>
				<th>Usuario</th>
				<th>Password</th>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Apellido P</th>
				<th>Apellido M</th>
				<th>E-mail</th>
			</tr>
		</thead>
		<tbody>
			<form action='agregar.php' method="post">
			<td>
				<div class="btn-group">
					<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-plus-sign"></span>
					</button>
				</div>
			</td>
			<td>
				<input type="text" name="user_form" class="form-control" placeholder="Usuario">
			</td>
			<td>
				<input type="text" name="pass_form" class="form-control" placeholder="Password">
			</td>
			<td>
				<input type="text" name="rut_form" class="form-control" placeholder="Rut">
			</td>
			<td>
				<input type="text" name="nombre_form" class="form-control" placeholder="Nombre">
			</td>
			<td>
				<input type="text" name="app_form" class="form-control" placeholder="Paterno">
			</td>
			<td>
				<input type="text" name="apm_form" class="form-control" placeholder="Materno">
			</td>
			<td>
				<input type="text" name="email_form" class="form-control" placeholder="E-mail">
			</td>
			</form>
		</tbody>
	</table>
</div>
<h2> Habilitados </h2>
<br>
<div class="table-responsive">
  <table class="table table-hover" id="editable">
    <thead>
      <tr>
        <th>Acciones</th>
        <th>ID</th>
        <th>User</th>
        <th>Password</th>
				<th>Rut</th>
        <th>Nombre</th>
        <th>Apellido P</th>
				<th>Apellido M</th>
				<th>E-mail</th>
				<th>Habilitado</th>
			</tr>
    </thead>
    <tbody>
  	     <?php
         $usuarios = "SELECT usuarios.id as u_id,
                             usuarios.username as u_user,
                             usuarios.password as u_pass,
                             usuarios.nombre as u_nombre,
                             usuarios.apellidop as u_ap,
                             usuarios.apellidom as u_am,
                             usuarios.rut as u_rut,
                             usuarios.email as u_email
                      FROM usuarios
											WHERE id != 1 and id != 0
												AND habilitado = 1
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
									 <li>
										 <?php echo "<li><a href='eliminar.php?id_el=" . $fila_usuarios["u_id"]. "'>Eliminar</a></li>"?>
								 	 </li>
									 <li>
										 <?php echo "<li><a href='deshabilitar.php?id=" . $fila_usuarios["u_id"]. "'>Deshabilitar</a></li>"?>
									 </li>
                 </ul>
               </div>
             </td>
         <?php
  			    echo "<td>" . $fila_usuarios["u_id"] . "</td>";
            echo "<td>" . $fila_usuarios["u_user"] . "</td>";
            echo "<td>" . $fila_usuarios["u_pass"] . "</td>";
						echo "<td>" . $fila_usuarios["u_rut"] . "</td>";
            echo "<td>" . $fila_usuarios["u_nombre"] . "</td>";
            echo "<td>" . $fila_usuarios["u_ap"] ."</td>";
						echo "<td>" . $fila_usuarios["u_am"] ."</td>";
						echo "<td>" . $fila_usuarios["u_email"] . "</td>";
						echo "<td> Si </td>";
            echo "</tr>";
  		   }?>
    </tbody>
  </table>
</div>
<h2> Inhabilitados </h2>
<br>
<div class="table-responsive">
  <table class="table table-hover" id="editable">
    <thead>
      <tr>
        <th>Acciones</th>
        <th>ID</th>
        <th>User</th>
        <th>Password</th>
				<th>Rut</th>
        <th>Nombre</th>
        <th>Apellido P</th>
				<th>Apellido M</th>
				<th>E-mail</th>
				<th>Habilitado</th>
			</tr>
    </thead>
    <tbody>
  	     <?php
         $usuarios = "SELECT usuarios.id as u_id,
                             usuarios.username as u_user,
                             usuarios.password as u_pass,
                             usuarios.nombre as u_nombre,
                             usuarios.apellidop as u_ap,
                             usuarios.apellidom as u_am,
                             usuarios.rut as u_rut,
                             usuarios.email as u_email
                      FROM usuarios
											WHERE id != 1 and id != 0
												AND habilitado = 0
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
								 	<li>
									 	<?php echo "<li><a href='eliminar.php?id_el=" . $fila_usuarios["u_id"]. "'>Eliminar</a></li>"?>
								 	</li>
								 	<li>
									 	<?php echo "<li><a href='habilitar.php?id=" . $fila_usuarios["u_id"]. "'>Habilitar</a></li>"?>
								 	</li>
									</ul>
               </div>
             </td>
         <?php
  			    echo "<td>" . $fila_usuarios["u_id"] . "</td>";
            echo "<td>" . $fila_usuarios["u_user"] . "</td>";
            echo "<td>" . $fila_usuarios["u_pass"] . "</td>";
						echo "<td>" . $fila_usuarios["u_rut"] . "</td>";
            echo "<td>" . $fila_usuarios["u_nombre"] . "</td>";
            echo "<td>" . $fila_usuarios["u_ap"] ."</td>";
						echo "<td>" . $fila_usuarios["u_am"] ."</td>";
						echo "<td>" . $fila_usuarios["u_email"] . "</td>";
						echo "<td> No </td>";
            echo "</tr>";
  		   }?>
    </tbody>
  </table>
</div>
<br><br>
</div>
<?php include('footer.php');?>
