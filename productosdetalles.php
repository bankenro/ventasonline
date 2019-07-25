<?php
require_once('conecta.php');
$cod = '';
$des = '';
$pre = '';
$can = '';
$sto = '';
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link rel="stylesheet" href="formularios.css" type="text/css">
</head>
<body>
<?php
$disable = '';
$accion = '';
if (isset($_GET['accion']))
    $accion = $_GET['accion'];
if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = $_GET['id'];
    $accion = $_GET['accion'];
    $stmt = $con->prepare('select * from producto where codigo like ?');
    $stmt->bindParam(1, $id, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $stmt = null;
    if ($accion == 'detalles' || $accion == 'editar' || $accion == 'eliminar') {
        if ($accion == 'detalles' || $accion == 'eliminar')
            $disable = 'disabled';
        $cod = $data[0]['codigo'];
        $des = $data[0]['descripcion'];
        $pre = $data[0]['precio'];
        $can = $data[0]['cantidad'];
        $sto = $data[0]['stock'];
    }
}
if (isset($_POST['sub'])) {
    $sub = $_POST['sub'];
    if (isset($_POST['cod']) && isset($_POST['des']) && isset($_POST['pre'])
        && isset($_POST['can']) && isset($_POST['sto'])) {
        $cod = $_POST['cod'];
        $des = $_POST['des'];
        $pre = $_POST['pre'];
        $can = $_POST['can'];
        $sto = $_POST['sto'];
    }
    switch ($sub) {
        case 'editar':
            $stmt = $con->prepare('update producto set descripcion = ?, precio =?,cantidad=?,stock=? where codigo like ?');
            $stmt->bindParam(1, $des, PDO::PARAM_STR);
            $stmt->bindParam(2, $pre, PDO::PARAM_STR);
            $stmt->bindParam(3, $can, PDO::PARAM_INT);
            $stmt->bindParam(4, $sto, PDO::PARAM_INT);
            $stmt->bindParam(5, $cod, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $stmt->closeCursor();
                $stmt = null;
                header('Location:default.htm');
            } else {
                $msg = '<tr><th colspan="2">No se pudo Editar</th></tr>';
            }
            break;
        case 'eliminar':
            $stmt = $con->prepare('delete from producto where codigo like ?');
            $stmt->bindParam(1, $cod, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $stmt->closeCursor();
                $stmt = null;
                header('Location:default.htm');
            } else {
                $msg = '<tr><th colspan="2">No se pudo Eliminar</th></tr>';
            }
            break;
        case 'agregar':
            if (!empty($cod) && !empty($des) && !empty($pre) && !empty($can) && !empty($sto)) {
                $stmt = $con->prepare('select * from producto where codigo like ?');
                $stmt->bindParam(1, $cod, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    $stmt->closeCursor();
                    $stmt = null;
                    $msg = '<tr><th colspan="2">Es un registro valido</th></tr>';
                    $stmt = $con->prepare('insert into producto (codigo, descripcion, precio, cantidad, stock) values (?,?,?,?,?)');
                    $stmt->bindParam(1, $cod, PDO::PARAM_STR);
                    $stmt->bindParam(2, $des, PDO::PARAM_STR);
                    $stmt->bindParam(3, $pre, PDO::PARAM_STR);
                    $stmt->bindParam(4, $can, PDO::PARAM_INT);
                    $stmt->bindParam(5, $sto, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        $stmt->closeCursor();
                        $stmt = null;
                        header('Location:default.htm');
                    } else {
                        $msg = '<tr><th colspan="2">No se pudo Agregar</th></tr>';
                    }
                } else {
                    $msg = '<tr><th colspan="2">Producto ya esta registrado</th></tr>';
                }
            } else {
                $msg = '<tr><th colspan="2">Complete todo el formulario</th></tr>';
            }
            break;
    }
}
?>
<marquee bgcolor="#CCCCCC"> Bienvenidos al Registro de Productos</marquee>
<form action="productosdetalles.php" method="post">
    <table align="center">
        <tr>
            <th colspan="2">
                <h1>DATOS DEL PRODUCTO</h1>
            </th>
        </tr>

        <tr>
            <th>CODIGO:</th>
            <td><input type="text" name="cod"
                       value="<?php echo $cod ?>" <?php
                       if ($accion == 'detalles' || $accion == 'editar' || $accion == 'eliminar'){
                       ?>disabled
                    <?php
                    }
                    ?>>
            </td>
        </tr>
        <tr>
            <th>DESCRIPCION:</th>
            <td><input type="text" name="des" value="<?php echo $des ?>" <?php echo $disable ?>></td>
        </tr>
        <tr>
            <th>PRECIO:</th>
            <td><input type="text" name="pre" size="50" value="<?php echo $pre ?>"<?php echo $disable ?>></td>
        </tr>
        <tr>
            <th>CANTIDAD:</th>
            <td><input type="text" name="can" size="50" value="<?php echo $can ?>"<?php echo $disable ?>></td>
        </tr>
        <tr>
            <th>STOCK:</th>
            <td><input type="text" name="sto" size="50" value="<?php echo $sto ?>"<?php echo $disable ?>></td>
        </tr>
        <tr>
            <th colspan="2">
                <input type="submit" name="sub" value="<?php echo $accion ?>" <?php
                if ($accion == 'detalles'){
                ?>disabled
                    <?php
                    }
                    ?>>
            </th>
        </tr>
    </table>
</form>
<?php if (!empty($msg)) echo $msg; ?>
</body>
</html>
