<?php
session_start();
$usuario = null;
if(!isset($_SESSION['vitrine-user'])){
    header('Location: login.php');
}else{
    $usuario = unserialize($_SESSION['vitrine-user']);
}