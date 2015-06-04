<?php
$today = getdate();
 print "la hora del server es: "  . $today['hours'] ;
?>

<?PHP

$post_hour = 20;
$today = getdate();

$hour_difference = $today['hours'] - $post_hour;

Print ".           Hasta las 20hs -ver zonahoraria- se puede dar de Baja, ahora hay de diferencia = " . $hour_difference;
if ($hour_difference < 0){
  Print ".         En horario ok " ;
}
else { 
  Print ".         En horario MAL! ";
}


?>

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

$usuarioCorto = explode('@', $user);
$usuarioCorto_ = ltrim($usuarioCorto[0]) + '';//Agregue estas comillas porque no me tomaba el String

$resultEmpleados = mysql_query("SELECT * FROM empleados where UsuarioCorto = $usuarioCorto_", $link);
echo "<em><u>usuarioCorto</em></u>:  $usuarioCorto_ <br> ";
$row = mysql_fetch_row($resultEmpleados);

if($resultEmpleados == null){

	echo "<div align=\"center\"> LOS DATOS INGRESADOS SON INCORRECTOS.</div><br>";
	return;
	
} else {

	echo "<div align=\"center\"> Bienvenido ".ucfirst($row[1]).". Tu PC esta alojada como $domain/$workstation"."</div><br>";
	$result = mysql_query("SELECT * FROM comidas where numeroDia = $numeroDia", $link);
	echo "<em><u>Dia</em></u>: ".mysql_result($result, 0, "letraDia")."<br>";
	echo "<em><u>Plato</em></u>: ".mysql_result($result, 0, "plato")."<br>";
	echo "<em><u>Guarnicion</em></u>: ".mysql_result($result, 0, "guarnicion")."<br>";
	
	$nroLegajo = $row[0];
	
	if($nroLegajo == NROLEGAJO_ADMIN){
		$result = mysql_query("SELECT COUNT(*) FROM asistencia where numeroDia = $numeroDia", $link);
		echo "<em><u>Cantidad de comensales</em></u>: ".mysql_result($result, 0)."<br>";
	}
	$queryAsistencia = mysql_query("SELECT * FROM asistencia where legajo = $nroLegajo");
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

$post_hour = 20;
$today = getdate();

$hour_difference = $today['hours'] - $post_hour;

//Print "Hasta las 20hs se puede dar de Baja, ahora hay de diferencia = " . $hour_difference;
if ($hour_difference < 0){
  //Print " En horario ok " ;
  if (isset($_POST["alta"])) {
	 
		$sql = "INSERT INTO asistencia (numeroDia, letraDia,usuarioNombre, legajo)";
		$sql.= "VALUES ('".$numeroDia."', '".$letraDia."', '".$user."', '".$nroLegajo."')";
		mysql_query($sql);
		$status = "ok";

}	
if (isset($_POST["baja"])) {
        $sql = "DELETE FROM asistencia ";
        $sql.= "WHERE legajo = ('".$nroLegajo."')";
        mysql_query($sql);
        $status = "ok";
		}

else { 
  Print " AVISO DEL IF, PARTE ELSE: En horario MAL! ";
 //avisoFueraDeHorario();
//<html lang="en">
//<head>
// <title>Curso de JavaScript</title> </head>     
//  <body onload="alert('Hola');">
//   <p>Tutorial de JavaScript</p>   
//    </body></html>
//echo "<script type='text/javascript'>alert('Usted')</script>";
//<script type="text/javascript">
//alert('Mensaje manejado con JavaScript');
//alert("Ya no puede inscribirse en el sistema, se ha cerrado porque son más de las 20hs (u 11hs) -ver zonahoraria-");

//<script language="javascript">
//alert("Error al insertar valores <?php echo $hour_difference;

}
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
