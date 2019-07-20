<?php
require_once('conecta.php');
$log = '';
$pas = '';
$nom = '';
$ape = '';
$dir = '';
$tel = '';
$ema = '';
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link rel="stylesheet" href="formularios.css" type="text/css">
</head>
<body>
<?php
if (isset($_POST['log']) && isset($_POST['pas']) && isset($_POST['nom'])
    && isset($_POST['ape']) && isset($_POST['dir']) && isset($_POST['tel'])
    && isset($_POST['ema'])) {
    $log = $_POST['log'];
    $pas = $_POST['pas'];
    $nom = $_POST['nom'];
    $ape = $_POST['ape'];
    $dir = $_POST['dir'];
    $tel = $_POST['tel'];
    $ema = $_POST['ema'];

    if (!empty($log) && !empty($pas) && !empty($nom) && !empty($ape) && !empty($dir)
        && !empty($tel) && !empty($ema)) {
        $stmt = $con->prepare('select * from cliente where login like ?');
        $stmt->bindParam(1, $log, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() <= 0) {
            $stmt->closeCursor();
            $stmt = null;
            $msg = '<tr><th colspan="2">Es un registro valido</th></tr>';
            $stmt = $con->prepare('insert into cliente (login, password, nombres, apellidos, direccion, telefono, email) values (?,?,?,?,?,?,?)');
            $stmt->bindParam(1, $log, PDO::PARAM_STR);
            $stmt->bindParam(2, $pas, PDO::PARAM_STR);
            $stmt->bindParam(3, $nom, PDO::PARAM_STR);
            $stmt->bindParam(4, $ape, PDO::PARAM_STR);
            $stmt->bindParam(5, $dir, PDO::PARAM_STR);
            $stmt->bindParam(6, $tel, PDO::PARAM_INT);
            $stmt->bindParam(7, $ema, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $stmt->closeCursor();
                $stmt = null;
                header('Location:default.htm');
            }
        } else {
            $msg = '<tr><th colspan="2">El cliente ya esta registrado</th></tr>';
        }
    } else {
        $msg = '<tr><th colspan="2">Complete todo el formulario</th></tr>';
    }
}
?>
<marquee bgcolor="#CCCCCC"> Bienvenidos al Registro de Clientes</marquee>
<form action="cliente.php" method="post">
    <table align="center">
        <tr>
            <th colspan="2">
                <h1>DATOS DEL CLIENTE</h1>
            </th>
        </tr>

        <tr>
            <th>LOGIN:</th>
            <td><input type="text" name="log" value="<?php echo $log ?>"></td>
        </tr>
        <tr>
            <th>PASSWORD:</th>
            <td><input type="password" name="pas" value="<?php echo $pas ?>"></td>
        </tr>
        <tr>
            <th>NOMBRES:</th>
            <td><input type="text" name="nom" size="50" value="<?php echo $nom ?>"></td>
        </tr>
        <tr>
            <th>APELLIDOS:</th>
            <td><input type="text" name="ape" size="50" value="<?php echo $ape ?>"></td>
        </tr>
        <tr>
            <th>DIRECCION:</th>
            <td><input type="text" name="dir" size="50" value="<?php echo $dir ?>"></td>
        </tr>
        <tr>
            <th>TELEFONO:</th>
            <td><input type="number" name="tel" value="<?php echo $tel ?>"></td>
        </tr>
        <tr>
            <th>EMAIL:</th>
            <td><input type="text" name="ema" size="35" value="<?php echo $ema ?>"></td>
        </tr>
        <tr>
            <th colspan="2">
                <input type="submit" value="Grabar">
            </th>
        </tr>
    </table>
</form>
<?php if (!empty($msg)) echo $msg; ?>
</body>
</html>