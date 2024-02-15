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
                $_SESSION["nomUserRegis"] = $nombreUsuario; // Establecer la variable de sesión
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
            $_SESSION["nomUser"] = $nomUserLogin; // Establecer la variable de sesión
            header("location: ../user.html");
            exit();
        } else {
            echo "Nombre de usuario o contraseña incorrecta.";
        }
    } 
}


// Guardar contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['password'])) {
    // Obtener la contraseña enviada desde el formulario
    $password = $_POST['password'];

    // Suponiendo que tengas el nombre de usuario del usuario actual almacenado en alguna variable de sesión
    $nombreUsuario_Login = $_SESSION["nomUser"]; // Asegúrate de cambiar esto por la variable de sesión correcta
    $nombreUsuario_Registro = $_SESSION["nomUserRegis"];

    // Consulta para obtener el ID del usuario
    $consultaUsuario_Login = "SELECT id_usuario FROM user WHERE nom_usuario = '$nombreUsuario_Login'";
    $resultado_usuario = $conector->query($consultaUsuario_Login);


    if ($resultado_usuario->num_rows > 0 ) {
        // Obtenemos el ID del usuario
        $fila_usuario = $resultado_usuario->fetch_assoc();
        $id_usuario = $fila_usuario['id_usuario'];

        // Insertamos la contraseña en la tabla password
        $sql = "INSERT INTO password (id_usuario, contrasenas) VALUES ('$id_usuario', '$password')";
        if ($conector->query($sql) === TRUE) {
            echo "Contraseña guardada correctamente";
        } else {
            echo "¡Error al guardar la contraseña: " ;
        }
    } else {
        echo "No se encontró ningún usuario con el nombre de usuario proporcionado.";
    }

    $conector->close();
}
?>


