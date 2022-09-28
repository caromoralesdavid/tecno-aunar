<?php
/* leer correo por metodo get*/
$correo = $_GET['correo'];
/*crear conexion a la base de datos*/
$conexion = mysqli_connect("localhost", "root", "", "tienda");
/*crear consulta para insertar datos*/
$insertar = "INSERT INTO tblcorreos(correo) VALUES ('$correo')";
/*ejecutar consulta*/
$resultado = mysqli_query($conexion, $insertar);
/*verificar si se inserto el dato*/
if (!$resultado) {
    echo 'Error al registrarse';
} else {
    echo '1';
}
/*cerrar conexion*/
mysqli_close($conexion);
