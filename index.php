<?php include("includes/top_page.php"); ?>
<?php include("includes/header.php"); ?>
<div id="contenido">
<?php 
$headers = apache_request_headers();
$user;
$domain;
$workstation;
include("login.php");
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

if(($resultEmpleados === FALSE)|| ($user == null)){ 
include("logueoErroneo.php");
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
	<strong>¡Atencion!</strong> El horario para darse de Alta/Baja permitido ha pasado. Para evitar inconvenites, la proxima vez ingrese más temprano. Por favor, si usted no ha sido dado de alta, hagalo ahora.
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
	
		$result = mysql_query("SELECT COUNT(*) FROM asistencia where numeroDia = $numeroDia and HOUR(horarioAsistencia)<11", $link);
		echo "<h4 style=\"color:gray\">Cantidad de comensales</em></u>: ".mysql_result($result, 0)."</h4>";
		$resultEmpleados = mysql_query("SELECT COUNT(*) FROM asistencia WHERE HOUR(horarioAsistencia)>11", $link);
		echo "<h4 style=\"color:gray\">Cantidad de comensales votaron fuera de horario</em></u>: ".mysql_result($resultEmpleados, 0)."</h4>";
		echo "<br>";
		echo "<br>";
	}
	// if($hs < 11){
	 // return;
	// }

	
}
include("BotonesYRespuestas.php");
//Se incluye el footer para la parte debajo de la pantalla
include("includes/footer.php");
?>