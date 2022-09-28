<?php
include "./Global/config.php";
include "llenando-carrito.php";
include "./Templates/cabecera.php";
?>
<br>
<br>
<h3>Lista del carrito: </h3>
<li class="nav-item active" align="right">
    <a class="nav-link" href="carrito.php">Regresar</a>
</li>
<!-- validar si exite algo en el carrito de compras -->
<?php
if (!empty($_SESSION['CARRITO'])) { ?>
    <table class="table table-light table-bordered">
        <tbody>
            <tr>
                <th width="40%">Descripción </th>
                <th width="15%" class="text-center">Cantidad </th>
                <th width="20%" class="text-center">Precio </th>
                <th width="20%" class="text-center">Total </th>
                <th width="5%">--- </th>
            </tr>
            <br>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                <tr>
                    <td width="40%"><?php echo $producto['NOMBRE']; ?></td>
                    <td width="15%" class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                    <td width="20%" class="text-center"><?php echo $producto['PRECIO']; ?></td>
                    <td width="20%" class="text-center"><?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
                    <td width="5%">
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">

                            <form action="" method="post">

                                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">

                                <button class="btn btn-danger" name="btnAccion" value="Eliminar" type="submit">
                                    Eliminar
                                </button>
                            </form>

                        </form>
                    </td>
                </tr>
                <?php $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
            <?php } ?>
            <tr>
                <td colspan="3" align="right">
                    <h3>Total</h3>
                </td>
                <td align="right"> <?php echo number_format($total, 2) ?> </td>
                <td> </td>
            </tr>

            <tr>
                <td colspan="5">

                    <form action="pagar.php" method="post">
                        <div class="alert alert-success" role="alert">
                            <div class="form-group">
                                <label for="my-input">Nombre: </label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                                <label for="my-input">Apellido: </label>
                                <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido" required>
                                <label for="my-input">Telefono: </label>
                                <input id="telefono" class="form-control" type="numero" name="telefono" placeholder="Ingresa tu telefono" required>
                                <label for="my-input">Correo: </label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Ingresa tu correo" required>
                                <label for="my-input">Direccion: </label>
                                <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Ingresa tu direccion" optional>

                            </div>
                            <small>
                                <div class="form-text text-muted" role="alert">
                                    Los productos se enviaran a la direccion que proporcionaste!
                                </div>

                            </small>
                        </div>


                        <button class="btn btn-primary btn-lg btn-block" name="btnAccion" value="proceder" type="submit">
                            Proceder a pagar
                    </form>


                </td>
            </tr>
        </tbody>
    </table>

<?php  } else { ?>
    <div class="alert alert-success">
        No hay productos en el carrito...
    </div>
<?php } ?>






<?php include "./Templates/pie.php"; ?>