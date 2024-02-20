<?php

    // Inicio la conexion a la base de datos.
    $host='localhost';
    $user="edib";
    $password="edib";
    $bd="usuarios";

    $conector=mysqli_connect($host,$user,$password,$bd);
    if($conector){
        echo "¡Bienvenido!"; 

    }else{
        echo "No se pudo conectar al servidor".mysqli_connect_error();
    }

?>