<?php

/* variable sesion start */
session_start();

/* variable mensaje  */
$mensaje = "";

/* evaluar el boton de agregar */
if (isset($_POST['btnAccion'])) {
    /* evaluar el valor del boton */
    switch ($_POST['btnAccion']) {
        case 'Agregar':

            /* variable id */
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                /* mostrar mensaje */
                $mensaje .= "Producto seleccionado:  "  . $ID . "</br>";
            } else {
                /* mostrar mensaje de error*/
                $mensaje .= "¡Ups! Algo salió mal..." . "</br>" . $ID;
            }
            /* validar el string y desencriptar el nombre */
            if (is_string(openssl_decrypt($_POST['nombre'], COD, KEY))) {
                $NOMBRE = openssl_decrypt($_POST['nombre'], COD, KEY);
                $mensaje .= "Nombre producto: " . $NOMBRE . "</br>";
            } else {
                /* mostrar mensaje de error*/
                $mensaje .= "¡Ups! Algo salió mal con el nombre..." . "</br>" . $NOMBRE;
                break;
            }
            /* validar el numero y desencriptar el precio */
            if (is_numeric(openssl_decrypt($_POST['precio'], COD, KEY))) {
                $PRECIO = openssl_decrypt($_POST['precio'], COD, KEY);
                $mensaje .= "Precio producto: " . $PRECIO . "</br>";
            } else {
                /* mostrar mensaje de error*/
                $mensaje .= "¡Ups! Algo salió mal con el precio..." . "</br>" . $PRECIO;
                break;
            }
            /* validar el string y desencriptar la cantidad */
            if (is_numeric(openssl_decrypt($_POST['cantidad'], COD, KEY))) {
                $CANTIDAD = openssl_decrypt($_POST['cantidad'], COD, KEY);
                $mensaje .= "Cantidad producto: " . $CANTIDAD . "</br>";
            } else {
                /* mostrar mensaje de error*/
                $mensaje .= "¡Ups! Algo salió mal con la cantidad..." . "</br>" . $CANTIDAD;
                break;
            }
            /* autoincrementar la cantidad del producto seleccionado */
            if (!isset($_SESSION['CARRITO'])) {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'PRECIO' => $PRECIO,
                    'CANTIDAD' => $CANTIDAD
                );
                $_SESSION['CARRITO'][0] = $producto;
                $mensaje = "¡Producto agregado al carrito!";
                $mensaje = "";
            } else {
                $idProductos = array_column($_SESSION['CARRITO'], "ID");
                if (in_array($ID, $idProductos)) {
                    //echo "<script>alert('El producto ya fué agregado!')</script>";
                } else {
                    $NumeroProductos = count($_SESSION['CARRITO']);
                    $producto = array(
                        'ID' => $ID,
                        'NOMBRE' => $NOMBRE,
                        'PRECIO' => $PRECIO,
                        'CANTIDAD' => $CANTIDAD
                    );

                    $_SESSION['CARRITO'][$NumeroProductos] = $producto;
                    $mensaje = "¡Producto agregado al carrito!";
                    $mensaje = "";
                }
                // $mensaje = print_r($_SESSION, true);

                break;
            }
        case 'Eliminar':
            /* evaluar el id */
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                /* mostrar mensaje */
                $mensaje .= "Producto seleccionado:  "  . $ID . "</br>";
                /* recorrr la sesion con un foreach */
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        //echo "<script>alert('Elemento borrado...');</script>";
                    }
                }
            } else {
                /* mostrar mensaje de error*/
                $mensaje .= "¡Ups! Algo salió mal..." . "</br>" . $ID;
            }
            break;
    }
}
