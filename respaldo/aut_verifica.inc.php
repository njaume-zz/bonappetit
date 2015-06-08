<?php
// Motor autentificacion usuarios.
// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");
// chequear pagina que lo llama para devolver errores a dicha pagina.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
//chequear si se llama directo al script.
if ($_SERVER['HTTP_REFERER'] == ""){
die (header ("Location: userpass.php?mensaje=Tenes que registrarte para ingresar."));
exit;
}
// Chequeamos si se esta autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {
// Conexion base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die(header ("Location:  $redir?error_login=0"));
mysql_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.
$sql_u = "SELECT id, usuario, password, nivel_acceso FROM $sql_tabla WHERE usuario='".$_POST['user']."'";

$usuario_consulta = mysql_query($sql_u) or die(header ("Location:  user_mal.php"));

 if ($_POST['user']=='' AND $_POST['pass']=='') {
 die (header ("Location: userpass.php?mensaje=Tenes que ingresar los datos."));
 exit;
}
 // miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysql_num_rows($usuario_consulta) != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    $password = md5($_POST['pass']);

    // almacenamos datos del Usuario en un array para empezar a chequear.
    $usuario_datos = mysql_fetch_array($usuario_consulta);

    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.
    mysql_close($db_conexion);

    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // pagina de error.
    if ($login != $usuario_datos['usuario']) {
       	Header ("Location: userpass.php?mensaje=Usuario inexistente. Intente nuevamente");
		exit;}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la pagina de error
    if ($password != $usuario_datos['password']) {
        Header ("Location: userpass.php?mensaje=El Password no es correcto. Intente nuevamente $pasword");
	    exit;}

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset($password);

    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.

     // le damos un mobre a la sesion.
    session_name($usuarios_sesion);
     // incia sessiones
    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta pagina.
    session_cache_limiter('nocache,private');

    // Asignamos variables de sesion con datos del Usuario para el uso en el
    // resto de paginas autentificadas.

    // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
    $_SESSION['usuario_id']         = $usuario_datos['id'];

    // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_nivel']      = $usuario_datos['nivel_acceso'];

    //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_login']      = $usuario_datos['usuario'];

    //definimos usuario_password con el password del usuario de la sesion actual (formato md5 encriptado)
    $_SESSION['usuario_password']   = $usuario_datos['password'];


    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;

   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: userpass.php?mensaje=Tenes que registrarte para ingresar.");
      exit;}
} else {

// -------- Chequear sesion existe -------

// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesion de identificacion del usuario,
// El caso mas comun es el de una vez "matada" la sesion se intenta volver hacia atras
// con el navegador.

if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
// Borramos la sesion creada por el inicio de session anterior
session_destroy();
Header ("Location: userpass.php?mensaje=Tenes que registrarte para ingresar 6.");
exit;
}
}
?>