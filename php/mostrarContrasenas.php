<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PASSWORD</title>
    
    <style>
        .cuadro_contrase{
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-radius: 10px;
        }

        

        .btnVolver{
    
            padding: 10px 20px;
            background-color:cornflowerblue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: auto;
        }
    </style>
</head>
<body>
<div class="cuadro_contrase">
<?php
// Inicia la sesión
session_start();

// Incluye el archivo de conexión
include("./conexion.php");

// Verifica si el usuario ha iniciado sesión y $_SESSION["id_usuario"] tiene un valor
if(isset($_SESSION["id_usuario"])) {
    // Obtén el ID del usuario de la sesión
    $idUsuario = $_SESSION["id_usuario"];

    // Consulta SQL para seleccionar las contraseñas del usuario específico
    $sentencia = "SELECT * FROM `password` WHERE `id_usuario` = '$idUsuario'"; 
    $resContra = mysqli_query($conector, $sentencia);

    // Verifica si la consulta fue exitosa
    if($resContra) {
        
        // Obtener el numero de contraseña encontradas.
        $num_Contra = mysqli_num_rows($resContra);

        if($num_Contra > 0) {
            // Mostrar mensaje
            echo "<br><br>Tienes <b>" . $num_Contra . "</b> contraseñas favoritas: ";

            
            while($info = mysqli_fetch_assoc($resContra)) {
                echo "<br><br> <b> ✔Contraseña:</b> " . $info['contrasenas'];
            }
        } else {
            echo "<br>No se encontraron contraseñas para este usuario.";
        }
    } else {
        echo "<br>Error al obtener los datos de la tabla <b>\"Passwords:\"</b>.";
    }
} else {
    echo "<br>No se ha iniciado sesión o el ID de usuario no está definido.";
}
?>   

    <br><br>
    <button class="btnVolver" onclick="window.location.href='../user.html';">Volver Atrás</button>
    </div>
</body>
</html>
