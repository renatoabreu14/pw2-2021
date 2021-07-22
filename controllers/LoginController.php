<?php
require_once "Conexao.php";
require_once "../models/Usuario.php";


class LoginController{

    private static $instance;
    private $conexao;

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new LoginController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function login($email, $senha){
        $usuario = $this->existeUsuario($email, $senha);
        if ($usuario->getNome() != ""){
            $_SESSION['vitrine-user'] = serialize($usuario);
            return true;
        }
        return false;
    }

    private function existeUsuario($email, $senha){
        $usuario = new Usuario();
        $sql = "SELECT id, nome, email, telefone FROM usuario WHERE email = :email AND senha =:senha";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":senha", $senha);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row){
            $usuario = $this->preencherUsuario($row);
        }
        return $usuario;
    }

    private function preencherUsuario($row){
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setEmail($row['email']);
        $usuario->setTelefone($row['telefone']);
        return $usuario;
    }
}