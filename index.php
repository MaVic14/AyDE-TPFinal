<!-- Se llaman a los include que daran imagen y forma a la pagina -->
<?php include("includes/top_page.php"); ?>
<?php include("includes/header.php"); ?>

<!-- Se setean los valores para el botón de Deslogueo -->
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
<br>
	<p align="right">
	<a href ="logueo.php" input class="btn btn-warning" type="submit">Desloguearse</a></p>
</form>

<div id="contenido">
<!-- Se inicia el codigo PHP con la conexion a la base de datos -->
<?php 
session_start();
$link = mysql_connect("localhost", "root"); 
mysql_select_db("baseayde", $link);
$user = $_GET['user'];


//Se obtienen los datos del dia
$numeroDia = date("N");
$letraDia = date ("l");

//Se setean variables
$nroLegajo = null;
$booleanhorario=false;
$queryAsistencia = null;
$hs = null;

//Se obtienen los datos y se ingresan en la variable
$result = mysql_query("SELECT CURTIME()");

while($row=mysql_fetch_array($result)){
	$hs = ($row["CURTIME()"]);
}

$hs = "10:00:00"; //agrede
//Se obtiene los datos de la query en la variable $resultEmpleados
$resultEmpleados = mysql_query("SELECT * FROM EMPLEADOS where NOMBRE = '".$result."'", $link);
//Lee el primer registro del $resultEmpleados y lo almacena en la variable 
$row = mysql_fetch_row($resultEmpleados);

// Consulta los datos de esa variable y los ingresa como Bienvenida al sistema
if($row[1] != null){
	echo "<h3 align=\"center\" style=\"color:gray\"> Bienvenido ".ucfirst($row[1])."</h3><br>";	
}else{
	echo "<h3 align=\"center\" style=\"color:gray\"> Bienvenido ".$user."</h3><br>";	
?>
	<!-- Muestra dos alert para el ingreso de comensales externos y el siguiente para el hroario -->
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
	
	// phpinfo();
	// Se verifica el horario para aquellos comensales que se inscriban 
	$hs = $hs + '';
	// Si el horario es mayor a 11.
	if($hs > 11){
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
	// Si el horario es menor a 11
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

}
// en BotonesYRespuestas.php se incluyen los botones de Alta/Baja
include("BotonesYRespuestas.php");
//Se incluye el footer para la parte debajo de la pantalla
include("includes/footer.php");
?>