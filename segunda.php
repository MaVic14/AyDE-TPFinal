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
	
	echo "<h3 align=\"center\" style=\"color:gray\"> Bienvenido ".ucfirst($row[1]).". Tu PC esta alojada como $domain/$workstation"."</h3><br>";
	$result = mysql_query("SELECT * FROM comidas where numeroDia = $numeroDia", $link);
	
	$hs = $hs + '';
	if($hs > 11){
		echo "<h4 style=\"color:white;background-color:rgb(128,128,128)\">El horario para darse de ALTA/BAJA ha pasado. Cualquier duda contactese con Sergio.</h4>";
		
	} else {
		echo "<h4 style=\"color:white;background-color:rgb(128,128,128)\">Tiene tiempo hasta las 11am. para darse de ALTA/BAJA.</h4>";
	}
	
	echo "<h4 style=\"color:gray\">Día: ".mysql_result($result, 0, "letraDia")."</h4>";
	echo "<h4 style=\"color:gray\">Plato: ".mysql_result($result, 0, "plato")."</h4>";
	echo "<h4 style=\"color:gray\">Guarnición: ".mysql_result($result, 0, "guarnicion")."</h4>";
	
	$nroLegajo = $row[2];

	if($nroLegajo == NROLEGAJO_ADMIN){
		$result = mysql_query("SELECT COUNT(*) FROM asistencia where numeroDia = $numeroDia", $link);
		echo "<h4 style=\"color:gray\">Cantidad de comensales</em></u>: ".mysql_result($result, 0)."</h4>";
	}
	if($hs > 11){
		return;
	}

	//EMI, aca esta lo de no permitir votar 2 veces. Hace la consulta preguntando si el legajo existe
	$queryAsistencia = mysql_query("SELECT * FROM asistencia where LEGAJO = $nroLegajo and NUMERODIA = $numeroDia");
	if($queryAsistencia != null){
		//echo "<h4 style=\"color:white;background-color:rgb(128,128,128)\">Recuerde que usted ya se ha dado de ALTA para asistir, lo esperamos!.</h4>";
	}
}
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
	<input class="btn btn-success" id= "1" name="alta" type="submit" onclick="abrirPopUpAlta()" value="Asistire">
	<input class="btn btn-danger" name="baja" type="submit" value="No Asistire" onclick="abrirPopUpBaja()"></p>
	<br>
</form>
<style type="text/css"> 
body{
background:#aaa;
}
</style> 

<?php
if (isset($_POST["alta"])) {?> 
	<script>
	 $('input[name="alta"]').attr('disabled','disabled')
	 </script><?php
		$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
		$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '".$nroLegajo."')";
		mysql_query($sql);
		if(mysql_error()){
			//echo "Le comunicamos que usted ya se ha dado de ALTA.";
			return;
		}
		$status = "ok";
}	
if (isset($_POST["baja"])) {
?> 
	<script>
	 $('input[name="baja"]').attr('disabled','disabled')
	 </script><?php
        $sql = "DELETE FROM asistencia ";
        $sql.= "WHERE legajo = ('".$nroLegajo."')";
        mysql_query($sql);
        $status = "ok";
		}
?>

<?php include("includes/footer.php"); ?>
<script>
function abrirPopUpAlta()
{
alert("Usted ha sido dado de alta en el sistema. Recuerde asistir al comedor a las 13:00 hs puntual");
}
function abrirPopUpBaja()
{
alert("Usted ha sido dado de baja en el sistema");
}
</script>

<!--Acá empieza lo de modificar el menú -->
<html>
<body>
<form action="segunda.php" method="post"> 
	<p align="center">
	<u> <b> <tittle>CAMBIO DE MENÚ<tittle/> </b> </u> <br/>
	Ingrese el día para el cual quiere cambiar el menú
	<input type="text" name="dia" /> <bR />
	Ingrese el nuevo menú para ese día
	<input type="text" name="nuevo" /> <bR />
	<input type="submit" value="Actualizar Menú" onclick="abrirPopUpModifMenu()" /> 
	</p>
	</form>
</body>
</html>

<?php
mysql_query("UPDATE comidas set PLATO='$_POST[nuevo]'
WHERE LETRADIA='$_POST[dia]'",$link) or die(misql_error());
?>

<script>
function abrirPopUpModifMenu()
{
alert("Usted ha modificado el menú con éxito");
}

</script>
