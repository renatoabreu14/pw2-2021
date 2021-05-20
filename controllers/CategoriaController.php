<?php
require_once "Conexao.php";
require_once "../models/Categoria.php";

class CategoriaController{

    private static $instance;
    private $conexao;

    /**
     * @return mixed
     */
    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new CategoriaController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function inserir(Categoria $categoria){
        $sql = "INSERT INTO categoria (descricao) VALUES (:descricao)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":descricao", $categoria->getDescricao());
        return $statement->execute();
    }

}