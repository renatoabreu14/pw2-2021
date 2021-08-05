<?php
session_start();

if(!isset($_SESSION['vitrine-user'])){
    header('Location: /progweb2.com.br/public_html/views/login.php');
}
