<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace library;

/**
 * Description of Request
 *
 * @author User
 */
class Request {
    //put your code here
    
    public static function isGet() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
            return false;
        }
        return true;        
    }
    
    
    public static function isPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return false;
        }
        return true;        
    }
    
    public static function getPost() {
         
        return $_POST;
        
    }  
    
    
    public static function isPut() {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT'){
            return false;
        }
        return true;        
    }
    
    
    public static function isPatch() {
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH'){
            return false;
        }
        return true;        
    }
    
    
}
