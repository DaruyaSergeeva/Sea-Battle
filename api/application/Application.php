<?php
    require_once('DB.php');
    require_once('User.php');
    require_once('Table.php');
    require_once('Game.php');
    require_once('Cookie.php');

    class Application{
        function __construct(){
            $this->user = new User();
            $this->table = new Table();
            $this->game = new Game();
        }



        //////////////////////////////////////
        ///////////////USER///////////////////
        //////////////////////////////////////


        //POST

        public function login($params){
            if($params['login'] && $params['password']){
                return $this->user->login($params['login'],$params['password']);
            }
            return ['Не введен логин или пароль']; 
        }

        public function logout($params){
            if($params['token']){
                return $this->user->logout($params['token']);
            }
            return ['Не произведен вход в аккаунт']; 
        }

        //
        public function registration($params){
            $login =  $params['login'];
            $password = $params['password'];
            $nickname = $params['nickname'];

            if(strlen($login) < 3 || strlen($login) > 30 ){
                return ['Логин неверной длины']; 
            }
            elseif(strlen($password) < 5) {
                return ['Пароль слишком короткий'];
            }
            elseif(strlen($nickname) < 3){
                return ['Никнейм слишком короткий'];
            }
            
            return $this->user->registration($login,$password,$nickname);
        }
        
      

        //GET


        public function getUserByToken($params){
            return $this->user->getUserByToken($params['token']);
        }

        public function getUserById($params){
            if($params['id']){
                return $this->user->getUserById($params['id']);
            }
            return ['Не введен id']; 
        }

        public function getStatsById($params){
            if($params['id']){
                return $this->user->getStatsById($params['id']);
            }
            return ['Не введен id']; 
        }



        ////////////////////////////////////////////////
        ///////////////////TABLE////////////////////////
        ////////////////////////////////////////////////
        

        //POST

        public function deleteTableById($params){
            if($params['id']){
                return $this->table->deleteTableById($params['id']);
            }
            return ['Не введен id']; // Не введен id
        }

        public function createTable($params){
            $name = $params['name'];
            $token = $params['token'];
             $count = 2;
            if($params['password']){
                $password = $params['password'];
            }
            else $password = null;

            //Обрабатываем исключения для кол-ва игроков
            if($count >= 2){
                $count = 2;
            }


            if($name && $token){
                return $this->table->createTable($token, $name, $count, $password);
            }
            return ['Нет имени стола']; //Нет имени стола
        }

        public function connectToTable($params){
            $token = $params['token'];
            $tableId = $params['id'];
            $user = $this->user->getUserByToken($token);
            if($user){
                $tables = $this->table->getTableById($tableId);
                if($tables){
                    $count = 2;
                    if($count < $tables['count']){
                        return $this->table->connectToTable($user['id'], $tableId);
                    }
                    return ['Кол-во игроков за столом максимально'];
                }
                return ['Такой стол не существует'];
            }
            return ['Не произведен вход в аккаунт'];
        }

        public function disconnectFromTable($params){
            $user = $this->user->getUserByToken($params['token']);
            if($user && $params['id']){
                return $this->table->disconnectFromTable($user['id'], $params['id']);
            }
            return ['Не введен id']; 
        }




        //GET

        public function getQuantPlayersOnTable($params){
            if($params['id']){
                return $this->table->getQuantPlayersOnTable($params['id']);
            }
            return ['Не введен id']; 
        }

        public function getAllTables(){
            return $this->table->getAllTables();
        }

        public function getTableById($params){
            if($params['id']){
                return $this->table->getTableById($params['id']);
            }
            return ['Не введен id']; 
        }


        //////////////////////////////////////////////////////
        ///////////////////GAME///////////////////////////////
        //////////////////////////////////////////////////////


        //POST

        public function winner($params){
            if($params['id'] && $params['count']){
                return $this->game->winner($params['id'],$params['count']);
            }
            return ['error','8'];
        }

        public function loser($params){
            if($params['id'] && $params['count']){
                return $this->game->loser($params['id'],$params['count']);
            }
            return ['error','8'];
        }

        public function checkCoord(){
            return $this->game->checkCoord();
        }

        

        //GET

        public function getRandomCoord($params){
            if($params['n']){
                return $this->game->getRandomCoord($params['n']);
            }
            return $this->game->getRandomCoord(19);
        }
    }
?>