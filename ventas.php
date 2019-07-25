<?php
require_once('conecta.php');
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link rel="stylesheet" href="formularios.css" type="text/css">
</head>
<body>
<?php
session_start();
$encontrado = 0;
$itemsEnCesta = array();
if (isset($_SESSION['registrado'])) {
    if ($_SESSION['registrado'] == 'SI') {
        echo "<marquee>Bienenid@ estimad@ cliente " . $_SESSION['log'] . "</marquee>";
        if (isset($_POST['pro'])) {
            $pro = $_POST['pro'];
            $stmt1 = $con->prepare('select * from producto where codigo like ?');
            $stmt1->bindParam(1, $pro, PDO::PARAM_STR);
            $stmt1->execute();
            $data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            $stmt1->closeCursor();
            $stmt1 = null;
        }
        if (isset($_POST['sub'])) {
            $sub = $_POST['sub'];
            switch ($sub) {
                case 'Agregar':
                    if (isset($_POST['pro']) && isset($_POST['can']) && isset($_POST['pre']) &&
                        isset($_POST['stk']) && isset($_POST['des'])) {
                        $item = $_POST['pro'];
                        $cantidad = $_POST['can'];
                        $precio = $_POST['pre'];
                        $stock = $_POST['stk'];
                        $descripcion = $_POST['des'];
                        if ($cantidad > 0 && $cantidad <= $stock) {
                            if (isset($itemsEnCesta)) {
                                $itemsEnCesta = $_SESSION['itemsEnCesta'];
                                if ($item) {
                                    if (!isset($itemsEnCesta)) {
                                        $itemsEnCesta[$item]['pro'] = $item;
                                        $itemsEnCesta[$item]['cantidad'] = $cantidad;
                                        $itemsEnCesta[$item]['precio'] = $precio;
                                        $itemsEnCesta[$item]['descripcion'] = $descripcion;
                                        $itemsEnCesta[$item]['subtotal'] = $cantidad * $precio;
                                        $itemsEnCesta[$item]['stock'] = $stock - $cantidad;
                                        //$itemsEnCesta[$item] = array('pro' => $item, 'cantidad' => $cantidad, 'subtotal' => $cantidad * $precio, 'stock' => $stock - $cantidad);
                                    } else {
                                        foreach ($itemsEnCesta as $k => $v) {
                                            if ($item == $k) {
                                                $itemsEnCesta[$k]['cantidad'] += $cantidad;
                                                $itemsEnCesta[$k]['subtotal'] = $itemsEnCesta[$k]['cantidad'] * $itemsEnCesta[$k]['precio'];
                                                $encontrado = 1;
                                            }
                                        }
                                        if (!$encontrado) {
                                            $itemsEnCesta[$item]['pro'] = $item;
                                            $itemsEnCesta[$item]['cantidad'] = $cantidad;
                                            $itemsEnCesta[$item]['precio'] = $precio;
                                            $itemsEnCesta[$item]['descripcion'] = $descripcion;
                                            $itemsEnCesta[$item]['subtotal'] = $cantidad * $precio;
                                            $itemsEnCesta[$item]['stock'] = $stock - $cantidad;
                                            //$itemsEnCesta[$item] = array('pro' => $item, 'cantidad' => $cantidad, 'subtotal' => $cantidad * $precio, 'stock' => $stock - $cantidad);
                                        }
                                    }
                                }
                                $_SESSION['itemsEnCesta'] = $itemsEnCesta;
                            }
                        } else {
                            echo '<script>window.alert("La cantidad es igual a 0 o sobrepaso el stock")</script>';
                        }
                    }
                    break;
                case 'Grabar compra':
                    if (isset($itemsEnCesta)) {
                        $tot = 0;
                        $itemsEnCesta = $_SESSION['itemsEnCesta'];
                        foreach ($itemsEnCesta as $k => $v) {
                            $stmt = $con->prepare('select * from producto where codigo like ?');
                            $stmt->bindParam(1, $k, PDO::PARAM_STR);
                            $stmt->execute();
                            $t = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $stmt->closeCursor();
                            $stmt = null;
                            $tot = $tot + ($t[0]['precio'] * $itemsEnCesta[$k]['cantidad']);
                        }
                        $fec = date('Y/m/d');
                        $log = $_SESSION['log'];
                        $stmt2 = $con->prepare('insert into venta (fecha, total, login,deposito)
                                                        values (?,?,?,?)');
                        $var1 = 1111111111;
                        $stmt2->bindParam(1, $fec, PDO::PARAM_STR);
                        $stmt2->bindParam(2, $tot, PDO::PARAM_STR);
                        $stmt2->bindParam(3, $log, PDO::PARAM_STR);
                        $stmt2->bindParam(4, $var1, PDO::PARAM_STR);
                        $stmt2->execute();
                        $stmt3 = $con->prepare('select max(numero_venta) as numv from venta where login like ? order by fecha desc');
                        $stmt3->bindParam(1, $log, PDO::PARAM_STR);
                        $stmt3->execute();
                        $r = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                        $numven = $r[0]['numv'];
                        foreach ($itemsEnCesta as $k => $v) {
                            $stmt4 = $con->prepare('insert into detalle (numero_venta, cantidad, codigo) VALUES (?,?,?)');
                            $stmt4->bindParam(1, $numven, PDO::PARAM_STR);
                            $stmt4->bindParam(2, $itemsEnCesta[$k]['cantidad'], PDO::PARAM_STR);
                            $stmt4->bindParam(3, $k, PDO::PARAM_STR);
                            if ($stmt4->execute()) {
                                $stmt4->closeCursor();
                                $stmt4 = null;
                                $stmt5 = $con->prepare('update producto set stock = stock-? where codigo like ?');
                                $stmt5->bindParam(1, $itemsEnCesta[$k]['cantidad'], PDO::PARAM_INT);
                                $stmt5->bindParam(2, $itemsEnCesta[$k]['pro'], PDO::PARAM_STR);
                                $stmt5->execute();
                                $stmt5->closeCursor();
                                $stmt5 = null;
                            }
                        }
                        session_destroy();
                        header("Location:default.htm");

                    }
                    break;
            }
        }
        ?>
        <table align="center">
            <form action="ventas.php" method="post" name="f">
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Precio/U</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                    <th rowspan="2">
                        <input type="submit" name="sub" value="Agregar">
                    </th>
                </tr>
                <tr>
                    <th>
                        <?php
                        $stmt = $con->prepare('select * from producto order by descripcion');
                        $stmt->execute();
                        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <select name="pro" onChange="enviar();">
                            <option value="0">Selecciona</option>
                            <?php
                            foreach ($res as $r) {
                                ?>
                                <option value="<?php echo $r['codigo']; ?>" <?php
                                if (isset($_POST['pro'])) {
                                    $pro = $_POST['pro'];
                                    if ($pro == $r['codigo']) {
                                        ?>
                                        selected
                                        <?php
                                    }
                                }
                                ?>><?php echo $r['codigo']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </th>
                    <th><input type="text" name="des" size="10" READONLY
                               value="<?php if (isset($data1)) echo $data1[0]['descripcion']; ?>"></th>
                    <th><input type="text" name="pre" size="10" READONLY
                               value="<?php if (isset($data1)) echo $data1[0]['precio']; ?>"></th>
                    <th><input type="text" name="stk" size="10" READONLY
                               value="<?php if (isset($data1) > 0) echo $data1[0]['stock']; ?>"></th>
                    <th><input type="number" value="0" name="can" size="3"></th>
                </tr>
            </form>
        </table>
        <?php
        if (isset($itemsEnCesta)) {
            ?>
            <table align="center" bgcolor="#99CCFF">
                <tr bgcolor="gray">
                    <th>N°</th>
                    <TD>Codigo</TD>
                    <td>Descripcion</td>
                    <td>Cantidad</td>
                    <td>Precio</td>
                    <td>Sub Total</td>
                </tr>
                <?php
                $c = 1;
                if (isset($_SESSION['itemsEnCesta']))
                    $itemsEnCesta = $_SESSION['itemsEnCesta'];
                foreach ($itemsEnCesta as $row) {
                    ?>
                    <tr>
                        <th><?php echo $c; ?></th>
                        <td><?php echo $row['pro']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        <td><?php echo $row['precio']; ?></td>
                        <td><?php echo $row['subtotal']; ?></td>
                    </tr>
                    <?php
                    $c++;
                }
                ?>
            </table>
            <?php
        }
    }
}
?>
</body>
<br>
<table align="center">
    <tr>
        <th>
            <form action="ventas.php" method="post">
                <input type="submit" name="sub" value="Grabar compra">
            </form>
        </th>
    </tr>
</table>
<script language="JavaScript">
    function enviar() {
        document.f.submit();
    }
</script>
</html>
