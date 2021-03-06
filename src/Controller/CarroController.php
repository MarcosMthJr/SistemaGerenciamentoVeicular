<?php
require_once 'src/Model/Carro.php';
require_once 'src/Config/PdoClass.php';
class CtrlCarro{    
    public function listCars() {
        $conn = Database::conexao();
        $sql = "SELECT id, modelo, ano, marca, potencia, valor FROM carro ORDER BY id DESC";
        $stmt = $conn->prepare($sql);

        try {          
            if ($stmt->execute()) {
                $carsFound = $stmt->fetchAll();
                return $carsFound;
            } else {
               return 0;
            }
        } catch (PDOException $ex) {
            echo 'Erro ao conectar no banco!' . $ex;
        }
    }
    
    
    
     public function insertCar(Carro $car) {
        $conn = Database::conexao();
        $sql = "SELECT id, modelo, ano, marca, potencia, valor FROM carro where modelo= ? 
        AND ano = ? AND marca = ? AND potencia = ? AND valor = ?";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->bindValue(1, $car->getModelo());
            $stmt->bindValue(2, $car->getAno());
            $stmt->bindValue(3, $car->getMarca());
            $stmt->bindValue(4, $car->getPotencia());
            $stmt->bindValue(5, $car->getValor());
            if ($stmt->execute()) {
                 if($stmt->fetch() > 1){
                    return 'encontrado';
                 } else {
               
                    $sql = "INSERT INTO carro(modelo, ano, marca, potencia, valor) values (?,?,?,?,?)";
                    
                    $stmt = $conn->prepare($sql);
                    
                    try {
                        $stmt->bindValue(1, $car->getModelo());
                        $stmt->bindValue(2, $car->getAno());
                        $stmt->bindValue(3, $car->getMarca());
                        $stmt->bindValue(4, $car->getPotencia());
                        $stmt->bindValue(5, $car->getValor());
        
        
                        if ($stmt->execute()) {
                            $lastId = $conn->lastInsertId();
                            return $lastId;
                        } else {
                        return 0;
                        }
                    } catch (PDOException $ex) {
                        echo 'Erro ao conectar no banco!' . $ex;
                    }
                    }
            }
        } catch (PDOException $ex) {
            echo 'Erro ao conectar no banco!' . $ex;
            }
        }
      
    
        
    
    
     public function searchCar($searchId) {
        $conn = Database::conexao();
        $sql = "SELECT id, modelo, ano, marca, potencia, valor FROM carro where id= ?";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->bindValue(1, $searchId);
            
            if ($stmt->execute()) {
                $carFound = $stmt->fetch();
                return $carFound;
            } else {
               return 0;
            }
        } catch (PDOException $ex) {
            echo 'Erro ao conectar no banco!' . $ex;
        }
    }
    
 
}

