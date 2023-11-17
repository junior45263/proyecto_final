<?php
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>'; 
    } else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];

        // Verificar la conexión antes de ejecutar la consulta
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Utilizar sentencias preparadas para evitar inyección SQL
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE usuario = ? AND clave = ?");
        $consulta->bind_param("ss", $usuario, $clave);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($datos = $resultado->fetch_object()) {
            // Iniciar sesión u otras acciones necesarias
            header("location: inicio.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Acceso Denegado</div>';
        }

        // Cerrar la consulta y la conexión
        $consulta->close();
        $conexion->close();
    }
}
?>
