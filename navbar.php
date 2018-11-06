<div class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <div class="dropdown navbar-brand">
        <?php
        if ($_SESSION['id'] == 1 or $_SESSION['id'] == 0) // Administradores
          { ?>
              <button style="background-color:rgba(0,0,0,0);border:0px;" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
              </button>
                <ul style="background-color:#0C1D46; width:60px;" class="dropdown-menu">
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='usuarios.php'> Usuarios </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='cargos.php'> Cargos </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='ciclos.php'> Ciclos </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='perfiles.php'> Perfiles </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='asignaturas.php'> Asignaturas </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='trabaja.php'> Trabajos </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href='superiores.php'> Superiores </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href="procesos.php"> Procesos </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href="competencias.php"> Competencias </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href="criterios.php"> Criterios </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href="metas.php"> Metas </a></li>
                  <li><a onmouseover="this.style='background-color:rgba(0,0,0,0);color:red';"
                         onmouseout="this.style='background-color:rgba(0,0,0,0);color:white';" style="color:white" href="indicadores.php"> Indicadores </a></li>
                </ul>
        <?php } ?>
      </div>
      <a href="welcome.php" class="navbar-brand"> Inicio </a>
      <?php
      if ($_SESSION['proceso_id'] != 0 and ($_SESSION['id'] != 1 && $_SESSION['id'] != 0)) {
        echo "<a href='proceso.php?proceso_id=".$_SESSION['proceso_id']."' class='navbar-brand'> Evaluaciones </a>";
      }
      if ( ($_SESSION['id'] == 1 or $_SESSION['id'] == 0) && $_SESSION['proceso_id'] != 0) {
        echo "<a href='resultados.php?proceso_id=".$_SESSION['proceso_id']."' class='navbar-brand'> Resultados </a>";
      } ?>
    </div>
  </div>
</div>
