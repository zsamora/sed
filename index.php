<?php
session_start();
// Re-direccionar a welcome si ya inició sesión
if(isset($_SESSION['id'])){
	header("Location: welcome.php");
}
// Incluir header y conexión
include('header.php');
include_once("db_connect.php");
?>
<br>
<div>
	<div class="col-md-1"></div>
	<div class="col-md-2"><br><img src="logosgc.png"></div>
  <div id="initial-text" class="col-md-6"><h1>Sistema de Evaluación del Desempeño</h1><h2>Saint Gaspar College</h2></div>
	<div class="col-md-3"></div>
</div>
<div>
	<br><br><br><br><br><br><br><br><br><br><br>
	<form class="form-login" method="post" id="login-form">
		<h2 id="text-loginbox">Complete sus datos</h2><br>
		<div id="error">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Usuario" name="user_name" id="user_name"/>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" />
		</div>
		<div id="button1" class="form-group">
			<button type="submit" class="btn btn-default" name="login_button" id="login_button">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Ingresar
			</button>
		</div>
	</form>
</div>
<?php include('footer.php');?>
