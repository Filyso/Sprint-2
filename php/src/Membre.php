<?php

class Membre {

    static function isLogged(){
        
        if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
            return true;
        }else{
            return false;
        }
        
    }
    
    static function isAdmin(){
        
        if(isset($_SESSION["role"])){
            if(Membre::isLogged() && $_SESSION["role"]=="admin"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    static function isModo(){
        
        if(isset($_SESSION["role"])){
            if(Membre::isLogged() && $_SESSION["role"]=="modo"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
  
}

?>