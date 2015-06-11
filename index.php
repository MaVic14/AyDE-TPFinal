<?php include("includes/top_page.php"); ?>
<?php include("includes/header.php"); ?>
<div id="contenido">
<?php 
$headers = apache_request_headers();
$user;
$domain;
$workstation;
if (!isset($headers['Authorization'])){
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: NTLM');
    exit;
}
define("NROLEGAJO_ADMIN",1000);
$auth = $headers['Authorization'];
if (substr($auth,0,5) == 'NTLM ') {
    $msg = base64_decode(substr($auth, 5));
    if (substr($msg, 0, 8) != "NTLMSSP\x00")
        die('error header not recognised');
    if ($msg[8] == "\x01") {
        $msg2 = "NTLMSSP\x00\x02\x00\x00\x00".
            "\x00\x00\x00\x00". // target name len/alloc
            "\x00\x00\x00\x00". // target name offset
            "\x01\x02\x81\x00". // flags
            "\x00\x00\x00\x00\x00\x00\x00\x00". // challenge
            "\x00\x00\x00\x00\x00\x00\x00\x00". // context
            "\x00\x00\x00\x00\x00\x00\x00\x00"; // target info len/alloc/offset
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: NTLM '.trim(base64_encode($msg2)));
        exit;
    }
    else if ($msg[8] == "\x03") {
        function get_msg_str($msg, $start, $unicode = true) {
            $len = (ord($msg[$start+1]) * 256) + ord($msg[$start]);
            $off = (ord($msg[$start+5]) * 256) + ord($msg[$start+4]);
            if ($unicode)
                return str_replace("\0", '', substr($msg, $off, $len));
            else
                return substr($msg, $off, $len);
        }
        $user = get_msg_str($msg, 36);
        $domain = get_msg_str($msg, 28);
        $workstation = get_msg_str($msg, 44);
		
    }
}
session_start(); 
$link = mysql_connect("localhost", "root"); 
mysql_select_db("baseayde", $link);
//Datos del insert
$numeroDia = date("N");
$letraDia = date ("l");
$nroLegajo = null;
$booleanhorario=false;
//Datos del insert

$queryAsistencia = null;
$hs = null;
$result = mysql_query("SELECT CURTIME()");
 
while($row=mysql_fetch_array($result))  
{
	$hs = ($row["CURTIME()"]);
}
//Ahora van a poner el nombre del usuario el mismo que USUARIOCORTO que esta en la base y con mayuscula
$resultEmpleados = mysql_query("SELECT * FROM EMPLEADOS where USUARIOCORTO = '".$user."'", $link);

if($resultEmpleados === FALSE){
	echo "<div align=\"center\"> LOS DATOS INGRESADOS SON INCORRECTOS.</div><br>";
	return;
	
} else {
	$row = mysql_fetch_row($resultEmpleados);
	if($row[1] != null){
	echo "<h3 align=\"center\" style=\"color:gray\"> Bienvenido ".ucfirst($row[1]).". Tu PC esta alojada como $domain/$workstation"."</h3><br>";	
	}else{
	echo "<h3 align=\"center\" style=\"color:gray\"> Bienvenido ".$user.". Tu PC esta alojada como $domain/$workstation"."</h3><br>";	
	}
	$result = mysql_query("SELECT * FROM comidas where numeroDia = $numeroDia", $link);
	?>
	
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>
	<head>   
	<link href="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">   
	<style type="text/css">  
	body {  
	padding: 40px;  
	}  
	</style>  
	</head>  
	<body>  
	
	<div class="alert alert-info">  
	<a class="close" data-dismiss="alert">×</a>  
	<strong>¡Atencion!</strong> Recuerde que para dar de alta a los comensales externos, sólo puede realizarlo una vez. Si ingresa erroneamente la cantidad primero debe darse de baja y luego ingresar de nuevo
	</div>  
	<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>  
	<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-alert.js"></script>  
	</body>  
	</html>
	<?php
	$hs = $hs + '';
	if($hs < 11){
	$booleanhorario=true;
	?>
	<html lang="en">  
	<head>   
	<link href="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">   
	<style type="text/css">  
	body {  
	padding: 40px;  
	}  
	</style>  
	</head>  
	<body>  
	
	<div class="alert alert-danger">  
	<a class="close" data-dismiss="alert">×</a>  
	<strong>¡Atencion!</strong> El horario para darse de ALTA/BAJA ha pasado. Por cualquier duda contactese con <a href="mailto:untref_tp_ayde@gmail.com">Sergio</a>
	</div>  
	<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>  
	<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-alert.js"></script>  
	</body>  
	</html>
	<?php echo "<br>";
	} else {
	?>
	<html lang="en">  
	<head>   
	<link href="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">   
	<style type="text/css">  
	body {  
	padding: 40px;  
	}  
	</style>  
	</head>  
	<body>  
	
	<div class="alert alert-success">  
	<a class="close" data-dismiss="alert">×</a>  
	<p><strong>¡Atencion!</strong> Tiene tiempo hasta las 11am. para darse de ALTA/BAJA </p>
	</div>  
	<script src="twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>  
	<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-alert.js"></script>  
	</body>  
	</html>
	<?php echo "<br>";
	}
	
	echo "<h4 style=\"color:gray\">Día: ".mysql_result($result, 0, "letraDia")."</h4>";
	echo "<h4 style=\"color:gray\">Plato: ".mysql_result($result, 0, "plato")."</h4>";
	echo "<h4 style=\"color:gray\">Guarnición: ".mysql_result($result, 0, "guarnicion")."</h4>";
	echo "<br>";

	
	$nroLegajo = $row[2];

	if($nroLegajo == NROLEGAJO_ADMIN){
		$result = mysql_query("SELECT COUNT(*) FROM asistencia where numeroDia = $numeroDia", $link);
		echo "<h4 style=\"color:gray\">Cantidad de comensales</em></u>: ".mysql_result($result, 0)."</h4>";
		echo "<br>";
		echo "<br>";
	}
	 if($hs > 11){
		 return;
	 }

	
}
if($booleanhorario==false){
?>
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
    alert("¡Atencion!: Usted ha sido dado de alta en el sistema. Recuerde asistir al comedor a las 13:00 hs puntual");
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
    alert("¡Atencion!: Usted ha sido dado de baja en el sistema. Si agrego comensales recuerde ingresar nuevamente los concurrentes");
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
		
		<script>alert("¡Atencion!: Usted no puede ingresar nuevos comensales. Para ello debe dar de baja y luego completar su asistencia y la de los invitados nuevamente")
		</script><?php
		}else{ ?>
		<script>alert("¡Atencion!: Usted no puede ingresar nuevos comensales. Para ello debe dar de baja y luego completar su asistencia y la de los invitados nuevamente")
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
	
<?php }//Se incluye el footer para la parte debajo de la pantalla ?>
<?php include("includes/footer.php"); ?>