<?php
session_start();
if (isset($_SESSION['vitrine-user'])){
    echo "teste";
    unset($_SESSION['vitrine-user']);
    header('Location: viewCategoria.php');
}

?>
