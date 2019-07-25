<?php
require_once('conecta.php');
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="Refresh" content="TIEMPO;url=URL">
    <link rel="stylesheet" href="productos.css" type="text/css">
</head>
<body>
<?php
if (isset($_POST['sub'])) {
    $sub = $_POST['sub'];
    switch ($sub) {
        case 'Buscar':
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $sql = 'select * from producto where ' . $tipo . ' like ? order by codigo';
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $stmt = null;
            break;
    }
} else {
    $stmt = $con->prepare('select * from producto order by codigo');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $stmt = null;
}
?>
<h2>Productos</h2>
<a href="verventas.php">Ventas</a>
<br>
<a href="productosdetalles.php?accion=agregar">Agregar Producto</a>
<br>
<table align="center">
    <form action="productos.php" method="post" name="f">
        <tr>
            <th><input type="text" name="nombre"></th>
            <th>
                <select name="tipo">
                    <option value="codigo"> CODIGO</option>
                    <option value="descripcion"> DESCRIPCION</option>
                    <option value="stock"> STOCK</option>
                </select>
            </th>
            <th rowspan="2">
                <input type="submit" name="sub" value="Buscar">
            </th>
        </tr>

        <br>
        <table id="t01">
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Stock</th>
                <th>Detalles</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            <?php
            foreach ($data as $row) {
                ?>
                <tr>
                    <td><?php echo $row['codigo'] ?></td>
                    <td><?php echo $row['descripcion'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['stock'] ?></td>
                    <td><a href="productosdetalles.php?id=<?php echo $row['codigo'] ?>&accion=detalles">Detalles</a>
                    </td>
                    <td><a href="productosdetalles.php?id=<?php echo $row['codigo'] ?>&accion=editar">Editar</a></td>
                    <td><a href="productosdetalles.php?id=<?php echo $row['codigo'] ?>&accion=eliminar">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
</body>
</html>