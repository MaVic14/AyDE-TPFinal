<!-- Declaramos el estilo del HTML -->
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
   
   <!-- Si el usuario es Sergio, mostrara modificar menu -->
    <p align="center">
    <?php if($nroLegajo == NROLEGAJO_ADMIN){ ?>
    <input type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" value="Modifcar Menu">
    <?php } ?>
	
	<!-- Cualquier usuario mostrara las 3 opciones: Agregar Comensal, Asistir, No Asistir -->
    <input type="button" name="agregaComensales" class="btn btn-primary" data-toggle="modal" data-target="#comensal" value="Agregar Comensales">
    <input class="btn btn-success" id= "1" name="altaValor" type="submit" onclick="darDeAlta()" value="Asistire">
    <input class="btn btn-danger" name="baja" type="submit" value="No Asistire" onclick="darDeBaja()"></p>
    
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
				<p>Ingrese el nuevo men&uacute</p>
			<input id="menu" name="menu" type="text" class="form-control input-md" >
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
				<p> Ingresar el numero de personas a sumar</p>
				<input id="ext" name="externos" type="number" min="0" max="10" class="form-control input-md" >
			</div>
			<div class="modal-footer">
				<input class="btn btn-success" name="agregaComensal" type="submit" value="Agregar" onclick="agregarComensal()">
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
<!-- Llama a la función luego de clickear el botón -->
<script>

	function darDeAlta(){
</script><?php
// Verifica si el usuario ya esta dado de alta
$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE usuarioNombre = '".$user."' and legajo = '".$nroLegajo."')");
$row = mysql_fetch_row($result);
if (isset($_POST["altaValor"])) {
	//Ingresa si el usuario no esta dado de alta
    if($row[0] == 0){
    $sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
    $sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '".$nroLegajo."')";
    mysql_query($sql);
    $status = "ok";
    // Luego de dar de alta. Se deshabilita el boton.
	?>
    <script>
    alert("Atencion: Usted ha sido dado de alta en el sistema. Recuerde asistir al comedor a las 13:00 hs puntual");
     $('input[name="altaValor"]').attr('disabled','disabled')
      $('input[name="baja"]').attr('enable','enable')

    </script><?php
    }
	//Si el $row[0] es igual a 1, deshabilita el boton ya que existe un registro
    else{?>
    <script>
    alert("Usted ya ingreso su asistencia. Le recordamos de asistir puntual en el horario de las 13.00");
    $('input[name="altaValor"]').attr('disabled','disabled')
    </script><?php
}
}?>
<script>}

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
    // Luego de dar de baja. Se deshabilita el boton y se habilita el alta.
	?>
    <script>
    alert("Atencion: Usted ha sido dado de baja en el sistema. Si agrego comensales recuerde ingresarlos nuevamente");
    $('input[name="baja"]').attr('disabled','disabled')
	$('input[name="altaValor"]').attr('enable','enable')
    </script><?php
    }
	//Si el $row[0] es igual a 0, deshabilita el boton ya que no existe un registro para eliminar
    else {?>
    <script>
    $('input[name="baja"]').attr('disabled','disabled')
    alert("No puede eliminar su asistencia ya que no esta confirmado en el sistema. Por favor para asistir presione en Asistiré");

    </script><?php
	}
	}?>
<script>}
	function agregarComensal(){
	</script><?php
	$result = mysql_query("SELECT exists ( SELECT * FROM asistencia WHERE usuarioNombre = '".$user."' and legajo = '1001')");
	$row = mysql_fetch_row($result);
	if (isset($_POST ["externos"])) {
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
		}?>
		
		<script>alert("Atencion: Usted ha realizado una carga de asistencia de personal externo. Tenga en cuenta que usted no puede ingresar nuevos comensales. Para ello debe dar de baja y luego completar su asistencia y la de los invitados nuevamente")
		</script><?php
		}else{ ?>
		<script>alert("Atencion: Usted no puede ingresar nuevos comensales. Para ello debe dar de baja y luego completar su asistencia y la de los invitados nuevamente")
		</script> 
		<?php
	}
	}
	}
	?>
    <script>
	}
	function modificarMenu(){
	</script><?php
	if(isset($_POST["modificarMenu"])){
	mysql_query("UPDATE comidas set PLATO='$_POST[menu]' WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
	?><script> alert ("Cambio de menu realizado con exito") </script><?php
	}
	?> <script>}</script>