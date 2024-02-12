<?php
<<<<<<< HEAD
=======
    
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
<<<<<<< HEAD
    
=======
    // 
>>>>>>> 02f1f3d48f5e2b2915b02158e40562ef1e4e622d

    if($pass1!==$pass2){
        echo"¡¡Las contraseñas deben ser las mismas.!!";
    }

<<<<<<< HEAD
        $sentencia="INSERT INTO `user` (`id_usuario`, `nom_usuario`, `correo`, `contrasena`)
        VALUES (NULL, '$nombreUsuario' , '$email', '$pass1')";
=======
        $sentencia = "INSERT INTO `user` ( `nom_usuario`, `correo`, `contrasena`)
        VALUES ('$nombreUsuario','$email','$pass1')";

>>>>>>> 02f1f3d48f5e2b2915b02158e40562ef1e4e622d
        
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
>>>>>>> 02f1f3d48f5e2b2915b02158e40562ef1e4e622d
