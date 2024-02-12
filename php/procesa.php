<?php

    include("./conexion.php");
    
    
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

    if($pass1!==$pass2){
        echo"¡¡Las contraseñas deben ser las mismas.!!";
    }


        // INSERTAR EL USUARIO EN LA BASE DE DATOS 
        $sentencia = "INSERT INTO `user` ( `nom_usuario`, `correo`, `contrasena`)
        VALUES ('$nombreUsuario','$email','$pass1')";

        $resultado=mysqli_query($conector,$sentencia);
        if($resultado){
            session_start();
            header('location: user.html');
        }else{
            echo "Error al registrarse";
        }
   
?>

