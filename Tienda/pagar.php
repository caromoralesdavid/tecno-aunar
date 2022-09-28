<!-- incluir el archivo config php que esta en global -->
<?php

include "./Global/config.php";
include "./Global/conexion.php";
include "llenando-carrito.php";
include "./Templates/cabecera.php";
?>
<?php
/* recepcionar la informacion de envio en el post */
if ($_POST) {
    $total = 0;
    $SID = session_id();
    $Correo = $_POST['email'];
    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
    }
    $sentencia = $pdo->prepare("INSERT INTO `tblventas` 
    (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `Status`) 
    VALUES (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
    $sentencia->bindParam(":ClaveTransaccion", $SID);
    $sentencia->bindParam(":Correo", $Correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->execute();
    $idVenta = $pdo->lastInsertId();
    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $sentencia = $pdo->prepare("INSERT INTO `tbldetalleventa` 
        (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `VENDIDO`) 
        VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");
        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $sentencia->execute();
    }
}
?>;
<!-- mostrar al usuario lo que se va a procesar en el pago -->
<div class="jumbotron text-center">
    <h1 class="display-4">¡Detalles Finales!</h1>
    <hr class="my-4">
    <p class="lead">Realizarás un pago a través de Paypal por valor de:
    <h4 class="parrafo-final">$<?php echo number_format($total, 2); ?></h4>
    <div id="paypal-button-container"></div>
    </p>
    <p class="parrafo-final">¡Los productos serán despachados una vez que se refleje el pago! <br>
        <strong class="parrafo-final">(Para aclaraciones: Ecomerce@Tecno-aunar.com)</strong>
    </p>

</div>
<!-- script de paypal -->
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout', // checkout | credit | pay | buynow | generic
            size: 'responsive', // small | medium | large | responsive
            shape: 'pill', // pill | rect
            color: 'gold' // gold | blue | silver | black
        },

        //paypal client IDS: replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
        client: {
            sandbox: 'AU0uahyuYDd3_Pm884O7Kp5LdPXmd2WBVqDxeEdwgcLKa85ktVIkPKXWSsLhnOWYBzKy2YkvKPeFCIDI',
            production: 'AdTjlWoj6-IOdwsDvXeuG7-3ACH8UIjFKY65tskg7g9Ln4Dsv85rFqNvbTRzMcNbOUDyRufEtrOAjC2c'
        },

        //funcion para procesar cantidad de pago paypal
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [{
                        amount: {
                            total: '<?php echo $total; ?>',
                            currency: 'COP'
                        }

                    }]
                }
            });
        },

        // Execute the payment:
        // 1. Add an onAuthorize callback
        onAuthorize: function(data, actions) {
            // 2. Make a request to your server
            return actions.payment.execute()
                .then(function() {
                    // 3. Show the buyer a confirmation message.
                    window.alert('¡Gracias por su compra!');
                });
        }
    }, '#paypal-button-container');
</script>


</div>







<?php include "./Templates/pie.php";  ?>