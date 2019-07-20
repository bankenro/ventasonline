<?php

try {
    $con = new PDO('mysql:host=localhost;port=3306;dbname=ventas;charset=utf8', 'admin', 'PASSWORD');
} catch (PDOException $e) {
    echo 'Error' . $e->getMessage();
}
