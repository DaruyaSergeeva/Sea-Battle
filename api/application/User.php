<?php
    class User{
        function __construct(){
            $this->db = new DB();
            $this->cookie = new Cookie();
            $this->secret = "qwefg0";
        }


        //POST

        public function login($login, $password){
            $user = $this->db->getUserByLogin($login);
            if($user){
                if(md5($login.$password.$this->secret) == $user['password']){
                    $rand = rand (0,100000);
                    $token = md5($user['password'].$rand);
                    $this->db->updateToken($user['id'], $token);
                    $this->cookie->updateTokenInCookie($token);
                    return ['true', $token];
                }
                return ['Введен неверный пароль']; 
            }
            return ['введен неверный логин']; 
        }

        public function logout($token){
            $user = $this->db->getUserByToken($token);
            if($user){
                $this->db->updateToken($user['id'], null);
                $this->cookie->deleteTokenInCookie();
                return true;
            }
            return ['Не произведен вход в аккаунт']; 
        }
        //
        public function registration($login,$password,$nickname){
            if($this->db->getUserByLogin($login)){
                return ['Пользователь с таким логином существует'];
            }
            $password = md5($login.$password.$this->secret);
            return $this->db->registrationUser($login, $password, null, $nickname);
        }



        //GET

        public function getUserByToken($token){
            return $this->db->getUserByToken($token);
        }

        public function getUserById($id){
            return $this->db->getuserbyid($id);
        }

    }
?>