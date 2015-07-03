<!-- Llama a la función luego de clickear el botón -->

<script>
	function darDeBaja(){
	</script><?php
	$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE numeroDia = $numeroDia and usuarioNombre = '".$user."')");
	$row = mysql_fetch_row($result);
	if (isset($_POST["bajaPropia"])) {
	//Ingresa si el usuario no esta dado de alta GAB_: esto baja ambos!!!
		if($row[0] == 1){
			$sql = "DELETE FROM asistencia ";
			$sql.= "WHERE numeroDia = $numeroDia and InvitaExternos = 0 and usuarioNombre = '".$user."'";
			mysql_query($sql);
			$status = "ok";
    	}
	}
    	if (isset($_POST["bajaExternos"])) {
    		//Ingresa si el usuario no esta dado de alta // GAB baja solo los externos
    		if($row[0] == 1){
    			$sql = "DELETE FROM asistencia ";
    			$sql.= "WHERE numeroDia = $numeroDia and InvitaExternos = 1 and usuarioNombre = '".$user."'";
    			mysql_query($sql);
    			$status = "ok";
    		}
	}?>
<script>}
	function agregarComensal(){
	</script><?php
	// Realiza la consulta si el usuario dado de alta ya existe en la base, GAB removi aca el filtrar x nro legajo, al pepe
	$consultaInterno = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE numeroDia = $numeroDia and usuarioNombre = '".$user."')");
	$valorConsulta = mysql_fetch_row($result);
	// Realiza la consulta si ya existen usuarios externos dados de alta por este usuario
	$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE numeroDia = $numeroDia and usuarioNombre = '".$user."')");
	$row = mysql_fetch_row($result);
	// Se verifican los datos ingresados
	if (isset($_POST ["externos"])) {
		if (isset($_REQUEST ["altaPropia"])) {
				if($valorConsulta[0] == 0){
					$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre,InvitaExternos)";
					$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."',0)";
					mysql_query($sql);
					$status = "ok";
					if(isset($_POST ["agregaComensal"])){
						$externos = $_POST ["externos"];
						$var =0;
						if($row[0] == 0){
						while ($var < $externos){
							$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre,InvitaExternos)";
							$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."',1)";
							mysql_query($sql);
							$status = "ok";
							$var++;
							}
						}
					}    
				}
		}else{
			if(isset($_POST ["agregaComensal"])){
						$externos = $_POST ["externos"];
						$var =0;
						if($row[0] == 0){
						while ($var < $externos){
							$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre,InvitaExternos)";
							$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."',1)";
							mysql_query($sql);
							$status = "ok";
							$var++;
							}
						}
					
				}
			}
			}
	?>
    <script>
	}
	function modificarMenu(){
	</script><?php
	if(isset($_POST["modificarMenu"])){
	mysql_query("UPDATE comidas set PLATO='$_POST[plato]' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
	?><script> alert ("Cambio de menu realizado con exito") </script>;
	<?php
		if (isset($_REQUEST['guarnicion'])){
				mysql_query("UPDATE comidas set GUARNICION='Ensaladas o Arroz' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
			}else{
				mysql_query("UPDATE comidas set GUARNICION='' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
				}
		
		}
		?>
	
		<script>
		function modificarHorarioAlmuerzo(){
				</script><?php
				if(isset($_POST["modificarHorarioAlmuerzo"])){
				mysql_query("UPDATE parametros set horarioalmuerzo='$_POST[horarioalmuerzo]'",$link) or die(misql_error());
				mysql_query("UPDATE parametros set horaLimite='$_POST[horarioMaximo]' ",$link) or die(misql_error());
				 ?> <script> alert("Cambio de Horario realizado con exito")</script>;
				<?php } ?>
			
		

<?php

	$result = mysql_query("SELECT horarioalmuerzo FROM parametros", $link);
	echo "<h4 style=\"color:blue\">El horario de almuerzo será a las </em></u> ".mysql_result($result, 0)."</h4>";

	// Se obtienen los datos de las comidas, dependiendo el dia	
	$result = mysql_query("SELECT * FROM comidas where numeroDia = $numeroDia", $link);
	// Setea los platos dependiendo el dia
	echo "<h4 style=\"color:gray\">Dia: ".mysql_result($result, 0, "letraDia")."</h4>";
	echo "<h4 style=\"color:gray\">Plato: ".mysql_result($result, 0, "plato")."</h4>";
	if (mysql_result($result, 0, "guarnicion") != ''){
	echo "<h4 style=\"color:gray\">Guarnicion: ".mysql_result($result, 0, "guarnicion")."</h4>";
	}
	echo "<br>";
	if($user == 'Sergio'){
	// Cuenta la cantidad de comensales inscriptos antes de la hora limite.
	//Trae la hora límite--------------------
	$result = mysql_query("SELECT horaLimite from parametros", $link);
	$horaMax = mysql_result($result, 0);
	//----------------------------------------
	$result = mysql_query("SELECT COUNT(*) FROM asistencia where numeroDia = $numeroDia and HOUR(horarioAsistencia)<'$horaMax'", $link);
	echo "<h4 style=\"color:gray\">Cantidad de comensales</em></u>: ".mysql_result($result, 0)."</h4>";
	// Cuenta la cantidad de comensales inscriptos después de la hora limite.
	$resultEmpleados = mysql_query("SELECT COUNT(*) FROM asistencia WHERE HOUR(horarioAsistencia)>'$horaMax' and numeroDia = $numeroDia", $link);
	echo "<h4 style=\"color:gray\">Cantidad de comensales votaron fuera de horario</em></u>: ".mysql_result($resultEmpleados, 0)."</h4>";
	}
	$total = mysql_query("SELECT exists ( SELECT * FROM ASISTENCIA where numeroDia = $numeroDia and invitaExternos = 0 and USUARIONOMBRE = '".$user."')");
	$asistencias = mysql_fetch_row($total);
	if($asistencias[0]==1){ 
		PRINT <<<HERE
		<html lang="en">
		<head>
			<p align="center">
			<FONT COLOR=#008000><span style="font-size: 30px;"> <b> USTED HA CONFIRMADO ASISTENCIA </b> <br/></span></FONT>
			</p>	
			</form>
		</head>
		</html>
HERE;
} else {
		PRINT <<<HERE
		<html lang="en">
		<head>
			<p align="center">
			<FONT COLOR=F41010><span style="font-size: 30px;"> <b> USTED NO HA CONFIRMADO ASISTENCIA </b> <br/></span></FONT>
			</p>
		</form>
	</head>
	</html>
HERE;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	$resultado = mysql_query("SELECT * FROM ASISTENCIA where numeroDia = $numeroDia and usuarioNombre = '".$user."' and invitaExternos = 1", $link);
	$numero_filas=0;
	$numero_filas = mysql_num_rows($resultado);
	if($numero_filas>=1){ 
	echo "<h4 style=\"color:green\">Externos agregados: $numero_filas </em></u> </h4>";
//		echo "<h4 style=\"color:green\">$numero_filas</em></u> </h4>";
		
		} else{
		 
		echo "<h4 style=\"color:orange\">No hay externos agregados</em></u> </h4>";
		
	}
	//------------------------------------------------------------------------------------------------------------------
	
	
	?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
</html>
<form action="" method="post" class="asistencia">
	<p align="center">
	<!-- Si el usuario es Sergio, mostrara modificar menu -->
	<?php 
		if($user == 'Sergio'){ ?>
		<input type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalhorario" value="Modificar Horario de Almuerzo">
	<input type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" value="Modificar Menu">
    <?php } ?>
	<!-- La opcion de Asistire y con comensales pertenece a todos los registrados, como también darse de baja -->
	<?php 
		// Si la consulta
		$total = mysql_query("SELECT exists ( SELECT * FROM ASISTENCIA where numeroDia = $numeroDia and USUARIONOMBRE = '".$user."')");
		$row = mysql_fetch_row($total);
		if($row[0]==0){ ?>
		<input type="button" id="agregar" name="agregaComensales" class="btn btn-success" data-toggle="modal" data-target="#comensal" value="Agregar Comensales">
	
	<?php } ?>	
	<?php
	//Si el horario es menor a hora limite
		//Trae la hora límite--------------------
	$result = mysql_query("SELECT horaLimite from parametros", $link);
	$horaMax = mysql_result($result, 0);
	//----------------------------------------
		//Si el $total es 1
		if($row[0]==1){ 
		// Si el horario es menor a las 11hs. todavia se puede dar de baja, de caso contrario no podrá
			if($hs <$horaMax){ 
			?>
			<input type="button" id="eliminarComensal" name="eliminarComensal" class="btn btn-danger" data-toggle="modal" data-target="#eliminar" value="No Asistire"></p>
	<?php 	}
		} ?>
	<!-- Abre el pop Up al Modificar el menu -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Modificar Men&uacute</h4>
			</div>
			<div class="modal-body">
				<p> Ingresar el d&iacutea que desea modificar</p>
				<input id="dia" name="dia" type="text" class="form-control input-md" >
				<p>Ingrese el nuevo plato</p>
				<input id="plato" name="plato" type="text" class="form-control input-md" >
				<p> </p>
				<input type="checkbox" name="guarnicion"> Permite guarnici&oacuten </br>
			</div>
			<div class="modal-footer">
				<input class="btn btn-info" name="modificarMenu" type="submit" value="Modificar" onclick="modificarMenu();location.href='index.php'">
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Abre el pop Up al Modificar el horario -->
	<div class="modal fade" id="myModalhorario" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Modificar Horario</h4>
			</div>
			<div class="modal-body">
				<p> Ingresar el nuevo horario de almuerzo(ej "13:30 hs")</p>
				<input id="horarioalmuerzo" name="horarioalmuerzo" type="text" class="form-control input-md" >
				
				<p> Ingresar el nuevo horario l&acuteimite para confirmar asistencia (ej "11:00")</p>
				<input id="horarioMaximo" name="horarioMaximo" type="text" class="form-control input-md" >
			</div>
			<div class="modal-footer">
				<input class="btn btn-info" name="modificarHorarioAlmuerzo" type="submit" value="Modificar Horarios" onclick="modificarHorarioAlmuerzo();location.href='index.php'">
			</div>
		  </div>
		</div>
	</div>
	
	
	<div class="modal fade" id="eliminar" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Eliminar Comensales</h4>
			</div>
			<div class="modal-body">
			<?php
				$consultaInterno = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE numeroDia = $numeroDia and invitaExternos = 0 and usuarioNombre = '".$user."')");
				$valorConsulta = mysql_fetch_row($consultaInterno);
				// Realiza la consulta si ya existen usuarios externos dados de alta por este usuario
				$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE numeroDia = $numeroDia and invitaExternos = 1 and usuarioNombre = '".$user."')");
				$row = mysql_fetch_row($result);
				if($valorConsulta[0] == 1){
				?>
				<input type="checkbox" name="bajaPropia"> Desea darse de baja </br>
				<?php	
					if($row [0]==1){ ?>
				<input type="checkbox" name="bajaExternos"> Desea dar de baja sus comensales</br>
				<?php }
				}else if($row [0]==1){
				?>
				<p> </p>
				<input type="checkbox" name="bajaExternos"> Desea dar de baja sus comensales</br>
				<?php } ?>
			</div>
			<div class="modal-footer">
				<input class="btn btn-danger" name="eliminarComensal" type="submit" value="Eliminar" onclick="darDeBaja();location.href='index.php'">
			</div>
		  </div>
		</div>
	</div>
	
		<div class="modal fade" id="comensal" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Agregar asistencia</h4>
			</div>
			<div class="modal-body">
			<input type="checkbox" name="altaPropia"> Confirma su asistencia </br>
			<p> </p>
			<p> Ingresar el numero de comensales externos que desea agregar</p>
				<input id="ext" name="externos" type="number" min="0" max="10" class="form-control input-md" >
			</div>
			<div class="modal-footer">
				<input class="btn btn-success" name="agregaComensal" type="submit" value="Agregar" onclick="agregarComensal();location.href='index.php'">
			</div>
		  </div>
		</div>
	</div>
</form>
<style type="text/css"> 
body{
background:#aaa;
}
</style>
