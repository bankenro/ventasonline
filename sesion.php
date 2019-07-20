<?php
require_once('conecta.php');
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="Refresh" content="TIEMPO;url=URL">
    <link rel="stylesheet" href="formularios.css" type="text/css">
</head>
<body>
<?php
if (isset($_POST['login']) && isset($_POST['clave'])) {
    $login = $_POST['login'];
    $pass = $_POST['clave'];
    $stmt = $con->prepare('select * from cliente where login like ? and password like ?');
    $stmt->bindParam(1, $login, PDO::PARAM_STR);
    $stmt->bindParam(2, $pass, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() <= 0) {
        echo '<script>window.alert("usuario no registrado")</script>';
        //header('Location:default.htm');
        $stmt->closeCursor();
        $stmt = null;
    } else {
        session_start();
        $stmt->closeCursor();
        $stmt = null;
        //deprecated
        //session_register('log');
        //$registrado = 'SI';
        //session_register('registrado');
        $log = '';
        foreach ($data as $row) {
            $log = $row['login'];
        }
        $_SESSION['log'] = $log;
        $_SESSION['registrado'] = 'SI';
        $_SESSION['itemsEnCesta'] = array();
        header('Location:ventas.php');
    }
} else {
    header('Location:default.htm');
}
?>
</body>
</html>
