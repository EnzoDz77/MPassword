<?php
    
    // Conexión a la base de datos.
    $host='localhost';
    $user="edib";
    $password="edib";
    $bd="usuarios";

    // CAPA DE SEGURIDAD
    //Nombre de Usuario 
    $nombreUsuario=$_POST["nomUserRegis"];
    //Restricción elimnare todos los espacios en blanco en el campo usuario
    $nombreUsuario = str_replace(' ', '', $nombreUsuario);

    //Validación de correo necesaria
    $email=$_POST['emailRegis'];
    /* Metodo para comprobar si el correo es valido el sigo '!' si el resultado 
    da un true lo niega entra en el if para mostrar el mensaje*/
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Esta dirección de correo no  es válida.";
    }

    // Validación de contraseñas  
    $pass1=$_POST['passRegis1'];
    $pass2=$_POST['passRegis2'];
    // 

    if($pass1!==$pass2){
        echo"¡¡Las contraseñas deben ser las mismas.!!";
    }

    $conector=mysqli_connect($host,$user,$password,$bd);
    if($conector){
        echo "Servidor conectado correctamete, Bienvenido".$user."!!"; 

        $sentencia = "INSERT INTO `user` ( `nom_usuario`, `correo`, `contrasena`)
        VALUES ('$nombreUsuario','$email','$pass1')";

        
        $resultado=mysqli_query($conector,$sentencia);
        if($resultado){
            echo "Bienvenido ".$nombreUsuario . "con correo :".$email; 
        }else{
            echo "Error al registrarse";
    }
    }else{
        echo "No se pudo conectar al servidor".mysqli_connect_error();
    }
?>