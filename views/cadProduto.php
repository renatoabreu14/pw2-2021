<?php
require_once "validarSessao.php";
require_once "../controllers/ProdutoController.php";
require_once "../controllers/CategoriaController.php";
require_once "../models/Usuario.php";
$usuario = new Usuario();


$produto = new Produto();
$lstCategorias = CategoriaController::getInstance()->getTodos();

if (isset($_GET['editar'])){
    $produto = ProdutoController::getInstance()->getProduto($_GET['editar']);
}

if (isset($_POST['enviar'])){
    $produto->setNome($_POST['nome']);
    $produto->setDescricao($_POST['descricao']);
    $produto->setValor($_POST['valor']);
    $produto->getCategoria()->setId($_POST['categoria']);
    if(isset($_FILES['pic']))
    {
        $ext = strtolower(substr($_FILES['pic']['name'],-4)); //Pegando extensão do arquivo
        $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
        $dir = '../images/products/'; //Diretório para uploads
        move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
        $produto->setImagem($new_name);
    }

    if(ProdutoController::getInstance()->gravar($produto)){
        header('Location: viewProduto.php');
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Dashboard Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    <?php
    require_once "assets.php";
    ?>


    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


    <!-- Favicons -->
    <!--<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">-->
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<?php
require_once "header.php"
?>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <?php
                require_once "menu.php";
                ?>

                <!--<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li>
                </ul>-->
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!--Conteúdo-->
            <div class="container-fluid">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $produto->getNome();?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao">Descricão:</label>
                        <textarea name="descricao" id="descricao" cols="30" rows="5" class="form-control"><?php echo $produto->getDescricao();?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categoria">Categoria:</label>
                        <select name="categoria" id="categoria" class="form-control">
                            <option value="0">Selecione uma categoria</option>
                            <?php
                                foreach ($lstCategorias as $categoria){
                                    if ($categoria->getId() == $produto->getCategoria()->getId()){
                                        echo "<option value='".$categoria->getId()."' selected>".$categoria->getDescricao()."</option>";
                                    }else{
                                        echo "<option value='".$categoria->getId()."'>".$categoria->getDescricao()."</option>";
                                    }

                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor">Valor:</label>
                        <input type="text" name="valor" id="valor" class="form-control" value="<?php echo $produto->getValor();?>">
                    </div>
                    <div class="mb-3">
                        <label for="imagem">Imagem:</label>
                        <input id="imagem" type="file" name="pic" accept="image/*" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-primary" type="submit" value="Salvar" name="enviar">
                        <a href="viewProduto.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="../js/dashboard.js"></script>
</body>
</html>
