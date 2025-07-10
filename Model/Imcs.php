<?php 

namespace Model;

use PDO;
use PDOException;
use Model\Connection;

class Imcs{
    // ATRIBUTO CRIADO PARA ESTABELECER CONEXÃO COM O BANCO DE DADOS
    private $db;

    public function __construct(){
        // CONEXÃO COM O BANCO DE DADOS
        $this -> db = Connection::getInstance();
    }

    // FUNÇÃO PARA CRIAR IMC
    public function createIMC($weight, $height, $result){
        try{
            // VARIÁVEL QUE ARMAZENAR OS DADOS 
            $sql = "INSERT INTO imcs (weight, height, result, created_at) 
            VALUES (:weight, :height, :result, NOW())";
            
            // PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO DO SQL
            $stmt = $this -> db -> prepare($sql);

            // PARÂMETROS QUE CADA COLUNA VAI RECEBER
            $stmt -> bindParam(":weight", $weight, PDO::PARAM_STR);
            $stmt -> bindParam(":height", $height, PDO::PARAM_STR);
            $stmt -> bindParam(":result", $result, PDO::PARAM_STR);
        
            return $stmt -> execute();
        } catch(PDOException $error){
            echo "Erro ao criar IMC: ". $error -> getMessage();
            return false;
        }
    }
}
?>