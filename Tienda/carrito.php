<!-- incluir el archivo config php que esta en global -->
<?php

include "./Global/config.php";
include "./Global/conexion.php";
include "llenando-carrito.php";
include "./Templates/cabecera.php";
?>


<br>
<br>
<!-- verificar si el mensaje está vacio -->
<?php
if ($mensaje != "")
?>
<div class="alert alert-success">

    <?php echo ($mensaje); ?>

    <a href="./mostrarCarrito.php" class="badge badge-success">Mostrar productos en cola.</a>
</div>

<div class="row">
    <!-- agregar php -->
    <?php
    $sentencia = $pdo->prepare("SELECT * FROM `tblproductos`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //print_r($listaProductos);
    ?>
    <?php foreach ($listaProductos as $producto) { ?>
        <div class="col-3">
            <div class="card">
                <!-- agregar el atributo data-toggle="popover" -->
                <img title="<?php echo $producto['Detalles']; ?>" height="250px" 
                alt="<?php echo $producto['Nombre']; ?>" 
                class="card-img-top" 
                src="<?php echo $producto['Imagen']; ?>" 
                data-html="true" 
                data-toggle="popover" 
                data-trigger="hover" 
                data-content="<?php echo $producto['Detalles']; ?>">

                <div class="card-body">
                    <span><?php echo $producto['Nombre']; ?></span>
                    <h5 class="card-title">$<?php
                                            /* imprimir precio con puntos de mil */
                                            echo number_format($producto['Precio'], 0, ',', '.'); ?></h5>
                    <p class="card-text">Detalles</p>

                    <!-- agregar un form con el metodo post -->
                    <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                        <!-- agregar el boton -->

                        <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">
                            Agregar al carrito
                        </button>

                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<br>

<script>
    /* crear la funcion popover */
    $(function() {
        $("[data-toggle=popover]").popover();
    })
</script>

<?php include "./Templates/pie.php";  ?>