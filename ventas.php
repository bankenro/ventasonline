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
            $data1 = $stmt1->fetch();
            $stmt1->closeCursor();
            $stmt1 = null;
        }
        if (isset($_POST['sub'])) {
            $sub = $_POST['sub'];
            switch ($sub) {
                case 'Agregar':
                    $item = $pro;
                    if (isset($_POST['can']))
                        $cantidad = $_POST['can'];
                    if (isset($itemsEnCesta) ) {
                        $itemsEnCesta = $_SESSION['itemsEnCesta'];
                        if ($item) {
                            if (!isset($itemsEnCesta)) {
                                $itemsEnCesta[$item] = $cantidad;
                            } else {
                                foreach ($itemsEnCesta as $k => $v) {
                                    if ($item == $k) {
                                        $itemsEnCesta[$k] += $cantidad;
                                        $encontrado = 1;
                                    }
                                }
                                if (!$encontrado || isset($encontrado))
                                    $itemsEnCesta[$item] = $cantidad;
                            }
                        }
                        $_SESSION['itemsEnCesta'] = $itemsEnCesta;
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
                            $tot += $t[0]['precio'] * $v;
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
                        $numven = $r[0]['numv'];;
                        foreach ($itemsEnCesta as $k => $v) {
                            $stmt4 = $con->prepare('insert into detalle (numero_venta, cantidad, codigo) VALUES (?,?,?)');
                            $stmt4->bindParam(1, $numven, PDO::PARAM_STR);
                            $stmt4->bindParam(2, $v, PDO::PARAM_STR);
                            $stmt4->bindParam(3, $k, PDO::PARAM_STR);
                            $stmt4->execute();
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
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Stock</th>
                    <th>Cantidad a Comprar</th>
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
                            <option value="0">Selecciona el producto a comprar...</option>
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
                                ?>><?php echo $r['codigo'] . '->' . $r['descripcion']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </th>
                    <th><input type="text" name="pre" size="10" disabled
                               value="<?php if (isset($data1)) echo $data1['precio']; ?>"></th>
                    <th><input type="text" name="stk" size="10" disabled
                               value="<?php if (isset($data1) > 0) echo $data1['stock']; ?>"></th>
                    <th><input type="text" name="can" size="10"></th>
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
                    <td>Cantidad</td>
                </tr>
                <?php
                $c = 1;
                if (isset($_SESSION['itemsEnCesta']))
                    $itemsEnCesta = $_SESSION['itemsEnCesta'];

                foreach ($itemsEnCesta as $k => $v) {
                    ?>
                    <tr>
                        <th><?php echo $c; ?></th>
                        <td><?php echo $k ?></td>
                        <td><?php echo $v ?></td>
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
