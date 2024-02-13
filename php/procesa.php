<?php
include("./conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["accion"] == "registro") {
        // Procesar registro
        // CAPA DE SEGURIDAD
        //Nombre de Usuario 
        $nombreUsuario = $_POST["nomUserRegis"];
        //Restricción eliminar todos los espacios en blanco en el campo usuario
        $nombreUsuario = str_replace(' ', '', $nombreUsuario);

        //Validación de correo necesaria
        $email = $_POST['emailRegis'];
        /* Método para comprobar si el correo es válido el signo '!' si el resultado 
        da un true lo niega entra en el if para mostrar el mensaje*/
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Esta dirección de correo no es válida.";
            exit();
        }

        // Validación de contraseñas  
        $pass1 = $_POST['passRegis1'];
        $pass2 = $_POST['passRegis2'];

        if ($pass1 !== $pass2) {
            echo "¡¡Las contraseñas deben ser las mismas.!!";
            exit();
        }
        // Verificar si el usuario ya existe en la base de datos
        $consulta = "SELECT * FROM `user` WHERE `nom_usuario` = '$nombreUsuario' OR `correo` = '$email'";
        $resultadoConsulta = mysqli_query($conector, $consulta);

        if (mysqli_num_rows($resultadoConsulta) > 0) {
            echo "<p>Ya existe un usuario con ese nombre de usuario o correo electrónico. ¡Por favor introduce nuevamente tus datos!</p>";
        } else {
            // INSERTAR EL USUARIO EN LA BASE DE DATOS 
            $sentencia = "INSERT INTO `user` (`nom_usuario`, `correo`, `contrasena`) VALUES ('$nombreUsuario','$email','$pass1')";
            $resultado = mysqli_query($conector, $sentencia);

            // Si el resultado devuelve true va a dirigir al usuario a la generadorPro
            if ($resultado) {
                header("location: ../user.html");
                exit();
            }
        }
    } elseif ($_POST["accion"] == "login") {
        // Procesar inicio de sesión
        $nomUserLogin = $_POST["nomUser"];
        $passLogin = $_POST['pass'];

        $consulta2 = "SELECT * FROM `user` WHERE `nom_usuario` = '$nomUserLogin' AND `contrasena` = '$passLogin'";
        $resultadoLogin = mysqli_query($conector, $consulta2);
        // Si encuentra ese usuario registrado en la base de datos ingresa al generadorPro
        if (mysqli_num_rows($resultadoLogin) > 0) {
            header("location: ../user.html");
            exit();
        } else {
            echo "Nombre de usuario o contraseña incorrecta.";
        }
    } 
} 
?>


