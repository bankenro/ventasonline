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
            switch ($tipo) {
                case 'fecha':
                    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo where fecha like ?');
                    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    $stmt = null;
                    break;
                case 'cliente':
                    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo where venta.login like ?');
                    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    $stmt = null;
                    break;
                case 'nombres':
                    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo where c.nombres like ?');
                    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    $stmt = null;
                    break;
                case 'codpro':
                    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo where d.codigo like ?');
                    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    $stmt = null;
                    break;
                case 'prod':
                    $nombre = '%' . $nombre . '%';
                    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo where p.descripcion like ?');
                    $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    $stmt = null;
                    break;
            }
            break;
    }
} else {
    $stmt = $con->prepare('select fecha,nombres as cliente,descripcion as producto from venta
                                    inner join detalle d on venta.numero_venta = d.numero_venta
                                    inner join cliente c on venta.login = c.login
                                    inner join producto p on d.codigo = p.codigo');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $stmt = null;
}
?>
<h2>VENTAS</h2>
<a href="verventas.php">Ventas</a>
<br>
<table align="center">
    <form action="verventas.php" method="post" name="f">
        <tr>
            <th><input type="text" name="nombre"></th>
            <th>
                <select name="tipo">
                    <option value="fecha">FECHA</option>
                    <option value="cliente">CLIENTE</option>
                    <option value="nombres">NOMBRE</option>
                    <option value="codpro">COD. PRODUCTO</option>
                    <option value="prod">PRODUCTO</option>
                </select>
            </th>
            <th rowspan="2">
                <input type="submit" name="sub" value="Buscar">
            </th>
        </tr>

        <br>
        <table id="t01">
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Producto</th>
            </tr>
            <?php
            foreach ($data as $row) {
                ?>
                <tr>
                    <td><?php echo $row['fecha'] ?></td>
                    <td><?php echo $row['cliente'] ?></td>
                    <td><?php echo $row['producto'] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
</body>
</html>
