<?php
    header('Access-Control-Allow-Origin: *');
    error_reporting(-1);
    require_once('application/Application.php');
    

    function router($params){
        $method = $params['method'];
        if($method){
            $app = new Application();
            switch($method){
                //регистрация и вход
                case 'registration': return $app ->registration($params);
                case 'login': return $app ->login($params);
                case 'logout': return $app ->logout($params);
                case 'createtable': return $app ->createTable($params);
                case 'deletetablebyid': return $app ->deleteTableById($params);
                case 'connecttotable': return $app->connectToTable($params);
                case 'disconnectfromtable': return $app->disconnectFromTable($params);
                //будет игра
                case 'checkcoord': return $app->checkCoord();//Написать
                //геты
                case 'getalltables': return $app ->getAllTables();
                case 'getuserbytoken': return $app ->getUserByToken($params);
                case 'getuserbyid': return $app->getUserById($params);
                case 'gettablebyid': return $app ->getTableById($params);
                case 'getrandomcard': return $app->getRandomCoord($params);
                case 'getquantplayersontable': return $app->getQuantPlayersOnTable($params);
            }
        }
        return false;
    }

    function answer($data){
        if($data!='error'){
            return array('result'=>'ok', 'data'=>$data);
        }
        else if(!$data){
            return array('result'=>'error');
        }
        return array('result'=>'error', 'data'=>'error'.$data);
    }

    if($_GET){
        echo(json_encode(answer(router($_GET))));
    }
    elseif($_POST){
        echo(json_encode(answer(router($_POST))));
    }
?>