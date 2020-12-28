<?php
class DB {
    function __construct() {
        $host = "SeaBattle";
        $user = "root";
        $pass = "root";
        $name = "database";
        try {
            $this->db = new PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
        } catch (PDOException $e) {
            print "Ошибка!: " . $e->getMessage();
            die();
        }
    }

    function __destruct() {
        $this->db = null;
    }


    //////////////////////////////////////
    ///////////////USER///////////////////
    //////////////////////////////////////


    //POST

    public function updateToken($id, $token) {
        $stmt = $this->db->prepare("UPDATE user SET token='$token' WHERE id='$id'");
        $stmt->execute();
        return ['ok', 'true'];
    }

    public function registrationUser($login, $password, $token, $nickname){
        $stmt = $this->db->prepare("INSERT INTO `user` ( `login`, `password`,`token`, `nickname`) VALUES ('$login','$password','$token','$nickname')");
        $stmt->execute();
        $stmt->fetch();
        return ['ok', 'true'];
    }

    //GET

    public function getUserByLogin($login) {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE login='$login'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    
    public function getUserByToken($token){
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE token='$token'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id){
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE id='$id'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }



    ////////////////////////////////////////////////
    ///////////////////TABLE////////////////////////
    ////////////////////////////////////////////////

    //POST

    public function deleteTableById($id){
        $stmt = $this->db->prepare("DELETE FROM `table` WHERE id='$id'");
        $stmt->execute();
        return ['ok', 'true'];
    }

    public function createTable($name, $count,  $password, $userId){
        if($password){
            $stmt = $this->db->prepare("INSERT INTO `table`(`name`, `count`, `active_players_id`,  `password`) VALUES ('$name','$count','$userId','$password')");
            $stmt->execute();
        }
        else{
            $stmt = $this->db->prepare("INSERT INTO `table`(`name`, `count`, `active_players_id`) VALUES ('$name','$count','$userId')");
            $stmt->execute();
        }
        return ['ok', 'true'];
    }

    public function connectToTable($userId, $tableId){
        $players = $this->getTableById($tableId)['active_players_id'];
        if($players){
            $players = $players." $userId";
            $stmt = $this->db->prepare("UPDATE `table` SET `active_players_id`='$players' WHERE id='$tableId'");
            $stmt->execute();
            return ['ok', 'true'];
        }
        return ['Игроков за столом нет']; //Игроков за столом нет
    }

    public function disconnectFromTable($userId, $tableId){
        $players = $this->getTableById($tableId)['active_players_id'];
        if($players){
            $players = explode(" ",$players);
            for($i = 0; $i < count($players); $i++){
                if($players[$i] == $userId){
                    array_splice ($players, $i ,1);
                }
            }
            $players = implode(" ", $players);
            $stmt = $this->db->prepare("UPDATE `table` SET `active_players_id`='$players' WHERE id='$tableId'");
            $stmt->execute();
            return ['ok', 'true'];
        }
        return ['Игроков за столом нет']; //Игроков за столом нет
    }



    //GET

    public function getAllTables() {
        $stmt = $this->db->prepare("SELECT * FROM table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTableById($id){
        $stmt = $this->db->prepare("SELECT * FROM table WHERE id='$id'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>