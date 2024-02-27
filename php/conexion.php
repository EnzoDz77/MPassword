<?php

    // Inicio la conexion a la base de datos.
    $host='bbdd.enzomejiaedib.com';
    $user="ddb220382";
    $password="lyjkWRNEk_6?;3";
    $bd="ddb220382";

    $conector=mysqli_connect($host,$user,$password,$bd);
    if($conector){
        echo "¡Hola!<br>"; 

    }else{
        echo "No se pudo conectar al servidor".mysqli_connect_error();
    }

?>