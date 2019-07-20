<?php
?>
<html lang="es">
<head>
    <title> TIENDA ONLINE</title>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link rel="stylesheet" href="portada.css" type="text/css">
</head>
<body>
<table align="center" width="800" class="tabla">
    <tr class="celda1">
        <td colspan="2">
            <h1>SISTEMA DE VENTAS ONLINE</h1>
            <h3> Aqui puede insertar un banner, etc.</h3>
        </td>
    </tr>
    <tr>
        <td width="150">
            <table>
                <tr class="celda1">
                    <td>
                        <form action="sesion.php" method="post" target="main">
                            Login:<br>
                            <input type="text" name="login"><br>
                            Password:<br>
                            <input type="password" name="clave"><br>
                            <input type="submit" value="Ir a comprar">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>
                        Si no esta registrado
                        <a href="cliente.php" target="main">registrese aqui</a>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <iframe src="default.htm" name="main" width="640" height="400"></iframe>
        </td>
    </tr>
</table>
</body>
</html>
