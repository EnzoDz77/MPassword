<?php
session_start();
session_destroy();
header("Location: ../index.html"); // Redirige a la página de inicio o a cualquier otra página deseada
exit();
?>
