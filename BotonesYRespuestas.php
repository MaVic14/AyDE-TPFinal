<!-- Declaramos el estilo del HTML -->

<!-- Llama a la función luego de clickear el botón -->
<script>
	function darDeBaja(){
	</script><?php
	$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE usuarioNombre = '".$user."')");
	$row = mysql_fetch_row($result);
	
	if (isset($_POST["baja"])) {
	//Ingresa si el usuario no esta dado de alta
		if($row[0] == 1){
			$sql = "DELETE FROM asistencia ";
			$sql.= "WHERE usuarioNombre = '".$user."'";
			mysql_query($sql);
			$status = "ok";
    ?>
    <script>
    alert("Atencion: Usted ha sido dado de baja en el sistema. Si agrego comensales recuerde ingresarlos nuevamente");
    $('input[name="altaValor"]').attr('enable','enable');
    </script><?php
	}
	}?>
<script>}
	function agregarComensal(){
	</script><?php
	// Realiza la consulta si el usuario dado de alta ya existe en la base
	$consultaInterno = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE usuarioNombre = '".$user."' and legajo = '".$nroLegajo."')");
	$valorConsulta = mysql_fetch_row($result);
	// Realiza la consulta si ya existen usuarios externos dados de alta por este usuario
	$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE usuarioNombre = '".$user."' and legajo = '1001')");
	$row = mysql_fetch_row($result);
	// Se verifican los datos ingresados
	if (isset($_POST ["externos"])) {
		if (isset($_REQUEST ["altaPropia"])) {
				if($valorConsulta[0] == 0){
					$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
					$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '".$nroLegajo."')";
					mysql_query($sql);
					$status = "ok";
					if(isset($_POST ["agregaComensal"])){
						$externos = $_POST ["externos"];
						$var =0;
						if($row[0] == 0){
						while ($var < $externos){
							$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
							$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '1001')";
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
							$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
							$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '1001')";
							mysql_query($sql);
							$status = "ok";
							$var++;
							}
						}
					
				}
			}
			?><script>$("#asistencia").load("index.php #asistencia"); </script> <?php
			}
	?>
    <script>
	}
	function modificarMenu(){
	</script><?php
	if(isset($_POST["modificarMenu"])){
	mysql_query("UPDATE comidas set PLATO='$_POST[plato]' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
		if (isset($_REQUEST['guarnicion'])){
		mysql_query("UPDATE comidas set GUARNICION='Ensaladas o Arroz' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
		}else{
		mysql_query("UPDATE comidas set GUARNICION='' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
		}
		}
	?><script> alert ("Cambio de menu realizado con exito");
	}
	</script>
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
	<input type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" value="Modificar Menu">
    <?php } ?>
	<!-- La opcion de Asistire y con comensales pertenece a todos los registrados, como también darse de baja -->
	<?php 
		// Si la consulta
		$total = mysql_query("SELECT exists ( SELECT * FROM ASISTENCIA where USUARIONOMBRE = '".$user."')");
		$row = mysql_fetch_row($total);
		if($row[0]==0){ ?>
		<input type="button" id="agregar" name="agregaComensales" class="btn btn-success" data-toggle="modal" data-target="#comensal" value="Agregar Comensales">
	
	<?php } ?>	
	<?php
	//Si el horario es menor a 11 hs.
		
		//Si el $total es 1
		if($row[0]==1){ 
		// Si el horario es menor a las 11hs. todavia se puede dar de baja, de caso contrario no podrá
			if($hs > 11){ 
			?>
			<input class="btn btn-danger" name="baja" type="submit" value="No Asistire" onclick="darDeBaja()"></p>
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
				<input class="btn btn-info" name="modificarMenu" type="submit" value="Modificar" onclick="modificarMenu()">
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