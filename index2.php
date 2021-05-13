<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        if (isset($_GET['nome'])){
            $nome = $_GET['nome'];
        }else{
            if (isset($_POST['nome'])){
                $nome = $_POST['nome'];
            }else{
                $nome = "";
            }
        }



        echo "<h1 style='color: blue'>Olá $nome!</h1>";
    ?>
    <!--<a href="index2.php?nome=Renato">Enviar</a>-->

    <form action="index2.php" method="post">
        <label for="numero">Informe o número de patinhos:</label>
        <input type="number" name="numero" id="numero">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

