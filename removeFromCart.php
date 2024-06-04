<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = $_POST['index'];
    if (isset($_SESSION['cart'][$index])) {
        array_splice($_SESSION['cart'], $index, 1);
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>