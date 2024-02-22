<?php
// Importo el archivo de la conexion
include("./conexion.php");
// Inicio la session
session_start();

// Verifico si los datos fueron enviados correctamente.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si es un usuario nuevo se llevara a cabo los filtros de registro.
    if ($_POST["accion"] == "registro") {

        // Hago otro filtro de validación aparte de las de javascript para una mayor seguridad.

        // CAPA DE SEGURIDAD
        //Nombre de Usuario 
        $nombreUsuarioRegis = $_POST["nomUserRegis"];
        //Restricción eliminar todos los espacios en blanco en el campo usuario
        $nombreUsuarioRegis = str_replace(' ', '', $nombreUsuarioRegis);

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
        $consulta = "SELECT * FROM `user` WHERE `nom_usuario` = '$nombreUsuarioRegis' AND `correo` = '$email'";
        $resultadoConsulta = mysqli_query($conector, $consulta);

        if (mysqli_num_rows($resultadoConsulta) > 0) {
            echo "<p>Ya existe un usuario con ese nombre de usuario o correo electrónico. ¡Por favor introduce nuevamente tus datos!</p>";
        } else {
            // Si no existe el usuario en la base de datos , lo insertamos en ella.
            $sentencia = "INSERT INTO `user` (`nom_usuario`, `correo`, `contrasena`) VALUES ('$nombreUsuarioRegis','$email','$pass1')";
            $resultado = mysqli_query($conector, $sentencia);

            // Si el resultado devuelve true va a dirigir al usuario a la generadorPro
            if ($resultado) {
                $_SESSION["nomUserRegis"]=$nombreUsuarioRegis ; // Con este usuario ya establezco la varible de session.

                // Consulta para obtener el ID del usuario
                $consultaIdUsuario = "SELECT id_usuario FROM user WHERE nom_usuario = '$nombreUsuarioRegis'";
                $resultadoIdUsuario = mysqli_query($conector, $consultaIdUsuario);
                if ($filaIdUsuario = mysqli_fetch_assoc($resultadoIdUsuario)) {
                 $_SESSION["id_usuario"] = $filaIdUsuario['id_usuario'];
                }
                header("location: ../user.html");   //Paso a dirigir a la página de usuario loegueado. 
                exit();
            }
        }

    // Si es un usuario existente hace los filtros de login.
    } elseif ($_POST["accion"] == "login") {
        // Procesar inicio de sesión
        $nomUserLogin = $_POST["nomUser"];
        $passLogin = $_POST['pass'];

        $consultaLogin = "SELECT * FROM `user` WHERE  BINARY `nom_usuario` = '$nomUserLogin' AND BINARY `contrasena` = '$passLogin'";
        $resultadoLogin = mysqli_query($conector, $consultaLogin);
        // Si encuentra ese usuario registrado en la base de datos ingresa al generadorPro
        if (mysqli_num_rows($resultadoLogin) > 0) {
            $_SESSION["nomUser"] = $nomUserLogin;   // Con este usuario ya establezco la varible de session.

            // Consulta para obtener el ID del usuario
            $consultaIdUsuarioLogin = "SELECT id_usuario FROM user WHERE nom_usuario = '$nomUserLogin'";
            $resultadoIdUsuarioLogin = mysqli_query($conector, $consultaIdUsuarioLogin);
            if ($filaIdUsuarioLogin = mysqli_fetch_assoc($resultadoIdUsuarioLogin)) {
            $_SESSION["id_usuario"] = $filaIdUsuarioLogin['id_usuario'];
            }
            header("location: ../user.html");
            exit();
        } else {
            // Mensaje de error en caso algo haya fallado.
            echo "Nombre de usuario o contraseña incorrecta.";
        }
    } 
}

// ====================================================================================================================

// Guardar contraseña
// Asegura ue los datos se han enviado correctamente
// Está logica esta enlazada con javascript ya ue como comente la contraseña se envía de ese archivo a este.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['password'])) {
    $password = $_POST['password'];
    // Tenemos ue tener la variable de session del usuario para guardar su contraseña pero antes de eso debemos de consulta su id.
    if (isset($_SESSION["nomUser"])) {
        $nombreUsuarioLogin = $_SESSION["nomUser"];
        
        // Consulta para obtener el ID del usuario del usuario que está logueado
        $consultaUsuarioLogin = "SELECT id_usuario FROM user WHERE nom_usuario = '$nombreUsuarioLogin'";
        $resultadoUsuarioLogin = $conector->query($consultaUsuarioLogin);
        
        // Verificar si se encontro algun usuario.
        if ($resultadoUsuarioLogin->num_rows > 0) {
            // Obtenemos el ID del usuario logueado
            $filaUsuarioLogin = $resultadoUsuarioLogin->fetch_assoc();
            $idUsuarioLogin = $filaUsuarioLogin['id_usuario'];

            // Insertamos la contraseña en la tabla password para el usuario logueado
            $consultaUsuarioLoPass = "INSERT INTO password (id_usuario, contrasenas) VALUES ('$idUsuarioLogin', '$password')";
            // Si todo a ido correcto inserta los datos a la tabla password.
            if ($conector->query($consultaUsuarioLoPass) === TRUE) {
                echo "Contraseña para usuario logueado guardada correctamente";
            } else {
                echo "¡Error al guardar la contraseña para usuario logueado. " ;
            }
        } else {
            echo "No se encontró ningún usuario logueado con el nombre de usuario proporcionado.";
        }
    
    // Esta otra secuencia lo hice en caso sea un usuario nuevo y directamente uiera guardar su contraseña es similar a la dada al inicio.
    } elseif (isset($_SESSION["nomUserRegis"])) {
        $nombreUsuarioRegistro = $_SESSION["nomUserRegis"];
        
        // Consulta para obtener el ID del usuario del usuario registrado
        $consultaUsuarioRegistro = "SELECT id_usuario FROM user WHERE nom_usuario = '$nombreUsuarioRegistro'";
        $resultadoUsuarioRegistro =  $conector->query($consultaUsuarioRegistro);

        // Verificar si se encontró algún usuario
        if ($resultadoUsuarioRegistro->num_rows > 0) {
            // Obtenemos el ID del usuario registrado
            $filaUsuarioRegistro = $resultadoUsuarioRegistro->fetch_assoc();
            $idUsuarioRegistro = $filaUsuarioRegistro['id_usuario'];

            // Insertamos la contraseña en la tabla password para el usuario registrado
            $consultaUsuarioRePass = "INSERT INTO password (id_usuario, contrasenas) VALUES ('$idUsuarioRegistro', '$password')";
            if ($conector->query($consultaUsuarioRePass) === TRUE) {
                echo "Contraseña para usuario registrado guardada correctamente";
            } else {
                echo "¡Error al guardar la contraseña para usuario registrado. " ;
            }
        } else {
            echo "No se encontró ningún usuario registrado con el nombre de usuario proporcionado.";
        }
    } else {
        echo "No se encontró ninguna sesión de usuario válida.";
    }
    $conector->close();
}

?>


