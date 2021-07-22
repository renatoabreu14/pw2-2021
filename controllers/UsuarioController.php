<?php
require_once "Conexao.php";
require_once "../models/Usuario.php";

class UsuarioController{
    private static $instance;
    private $conexao;

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new UsuarioController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function getTodos(){
        $lstRetorno = array();
        $sql = "SELECT * FROM usuario ORDER BY nome ";
        $statement = $this->conexao->query($sql, PDO::FETCH_ASSOC);
        foreach ($statement as $row){
            $lstRetorno[] = $this->preencherUsuario($row);
        }
        return $lstRetorno;
    }

    private function preencherUsuario($row){
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setEmail($row['email']);
        $usuario->setTelefone($row['telefone']);

        return $usuario;
    }

    public function gravar(Usuario $usuario){
        if ($usuario->getId() == null){
            return $this->inserir($usuario);
        }else{
            return $this->alterar($usuario);
        }
    }

    private function inserir(Usuario $usuario){
        $sql = "INSERT INTO usuario (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $usuario->getNome());
        $statement->bindValue(":email", $usuario->getEmail());
        $statement->bindValue(":telefone", $usuario->getTelefone());
        $statement->bindValue(":senha", $usuario->getSenha());
        return $statement->execute();
    }

    private function alterar(Usuario $usuario){
        $sql = "UPDATE usuario SET nome = :nome, telefone=:telefone WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $usuario->getNome());
        $statement->bindValue(":telefone", $usuario->getTelefone());
        $statement->bindValue(":id", $usuario->getId());
        return $statement->execute();
    }

    public function getUsuario($id){
        $usuario = new Usuario();
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row){
            $usuario = $this->preencherUsuario($row);
        }
        return $usuario;
    }

    public function delete($id){
        $sql = "DELETE FROM usuario WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        return $statement->execute();
    }
}