<div id="navbar" class="navbar-collapse collapse">
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $_SESSION['nombre']." ".$_SESSION['apellidop']." (".$_SESSION['username'].") "; ?>&nbsp;<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="perfil.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Ver Perfil</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a></li>
      </ul>
    </li>
  </ul>
</div>
