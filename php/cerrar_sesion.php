<?php
include("./conexion.php");
// El usuario al cerrar session se destruye todas las variables de session y cerramos la conexion a la base de datos.
session_start();
session_destroy();
$conector->close();
header("Location: ../index.html"); // Dirigimos a la página por defecto.
exit();

?>
