<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $car = json_decode($_POST['car'], true);

    array_push($_SESSION['cart'], $car);

    echo 'success';
} else {
    echo 'error';
}
?>