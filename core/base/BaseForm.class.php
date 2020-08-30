<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base;

use library\Db ;
use library\Validator;
/**
* Description of BaseForm
*
* @author User
*/

abstract class BaseForm  {
    
    protected $_db;
    protected $_errors =[];
    protected $_data;
    
    protected $_validator =null;
    protected $_tableName;
        
    protected $_ittemPerPage = POST_FOR_PAGE; // к-сть постів на сторінці
    public $_maxPageNum;     
    public $_currentPage;
    public $_uripage;
        
    
    public function __construct() {

        $this->_db = Db::getDb();

    }
    
    abstract public function getRules() ;
    

    public function validate() {
    
    
        $validator = new Validator($this->_data, $this->getRules());

        if(!empty($this->_tableName)){

            $validator->setTable($this->_tableName);             
        }
                    
        $resvalid= $validator->validateThis();

        if (!$resvalid) {

            $this->_errors = $validator->getErrors();
            
            return false;
        }
                
        return true;
        
    }
        
    public function load($data){
        
        foreach ($data as $propName=>$propValue) {
 
            if (property_exists(static::class, $propName)){
                
                $propValue = $this->_db->getSafeData($propValue);
                
                $this->$propName = $propValue;
                
                $this->_data[$propName] = $propValue;

            } else {
                return false;
            }
        }
        return true;
    }

    public function getErrors() {
        
        return $this->_errors;
    }
        
    public function getAddWhereByStatus($status='published') {

         if ( !isset($_SESSION['user']['role']) or $status=='published' )  {
                        
            $addWhere=" `status` >= ".POST_STATUS_PUBLISHED; 
            
        }                        
        
        
//        elseif ( $status=='published') {  $addWhere=" `status` >= ".POST_STATUS_PUBLISHED; }

        elseif ($status=='moderation' and $_SESSION['user']['role']=='user')
            {
             $addWhere=" (  `author_id` = '{$_SESSION['user']['id']}' 
                        and  
                          `status` = ".POST_STATUS_MODERATION." )";          
            }

            
        elseif ($status=='moderation' AND $_SESSION['user']['role']=='admin') 

            { $addWhere="`status` = ".POST_STATUS_MODERATION;  }


            
        elseif ($status=='deleted' and $_SESSION['user']['role']=='user')
            {
             $addWhere=" (  `author_id` = '{$_SESSION['user']['id']}' 
                        and  
                          `status` = ".POST_STATUS_DELETED." )";          
            }

        elseif ($status=='deleted' AND $_SESSION['user']['role']=='admin') 

            { $addWhere=" `status` = ".POST_STATUS_DELETED;  }



            
            
        elseif ($status=='all' and $_SESSION['user']['role']=='user')
            {
             $addWhere=" `status` >= ".POST_STATUS_DELETED." and  `author_id` = '{$_SESSION['user']['id']}' ";          
            }                

        elseif ($status=='all' AND $_SESSION['user']['role']=='admin') 

            { $addWhere=" `status` >= ".POST_STATUS_DELETED;  }
            
        else 
        
            { $addWhere=" `status` >= ".POST_STATUS_PUBLISHED;  }

        return $addWhere;    
    }
            
    public function getMaxPageNumber($table, $postPerPage, $status='published') {

       $addWhere=$this->getAddWhereByStatus($status);

       if (!empty($addWhere)) {$addWhere=' WHERE '.$addWhere;;} 

       $sql=" SELECT COUNT(*) FROM $table $addWhere";     

       $countP = $this->_db->sendSelectQuery($sql)->fetch_row();

       return ceil($countP['0']/$postPerPage);
    }        
}

