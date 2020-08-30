<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author User
 */
namespace library;                                                                                                                                               ;

class Db {
    
    private static $_db = null;
    private $_link;    
    
    private function __construct() {
        
        if (!file_exists(__DIR__.'/../config/db_conf.php')){
            throw new \Exception('Config db not found','404');
        }
        
        $config = require_once __DIR__.'/../config/db_conf.php'; 
        
        $this->_link = @new \mysqli($config['host'], $config['user'],$config['password'],$config['db_name']);
        
        if ($this->_link->connect_error){
            
            throw new \Exception($this->_link->connect_error);        
        }
        
        $this->_link->set_charset('utf8');
        
    }
        
    public static function getDb(){

        if (is_null(self::$_db)){
            //self::$_db = new Db();
            self::$_db = new self();
        }        
        return self::$_db;
    }           
    
    public function sendSelectQuery($param) {
        
        $result = $this->_link->query($param);
        
        if(!$result){
            throw new \Exception($this->_link->error);            
        }
        return $result;
    }
        
    public function sendInsUpDelQuery($param) { 
    
        $result = $this->_link->query($param);
        
        if(!$result){
            throw new \Exception($this->_link->error);
        }
        return $result;
        
    }
    
    public function getSafeData($param) {
        
        return $this->_link->escape_string($param);
        
    }
    
    public function getLastInsertId() {
        
        return $this->_link->insert_id;
        
    }
    
    
}
