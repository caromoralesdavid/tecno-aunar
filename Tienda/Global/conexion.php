<!-- conexion al servidor con php-->
<?php
$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;
try {

    $pdo = new PDO(
        $servidor,
        USUARIO,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    //echo "<script>alert('┬íConexion exitosa!')</script>";
} catch (PDOException $e) {


    //echo "<script>alert('┬íConexion fallida!')</script>";
}


?>