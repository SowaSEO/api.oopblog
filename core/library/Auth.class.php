<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace library;

/**
 * Description of Auth
 *
 * @author User
 */

class Auth{
    
    public static function isGuest() {
        if (empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }
    
    
    public static function isUser() {
       if (!empty($_SESSION['user']) and $_SESSION['user']['role']=='user') {
            
            return true;
            
        }
        return false;
    }
    
    public static function isAdmin() {
        
        if (!empty($_SESSION['user']) and $_SESSION['user']['role']=='admin') {
            
            return true;
            
        }
        return false;
        
    }
    
    public static function canStatus($status){
        if ($_SESSION['user']['role']==$status) {
            return true;
        }
            return false;
    }
            
    public static function login($id, $role,$nickname) {
        $_SESSION['user']['id']=$id;
        $_SESSION['user']['role']=$role;  
        $_SESSION['user']['nickname']=$nickname;  
    }
    
    
    public static function logout() {
        session_unset();
//        session_destroy();
        
    }
    
    public static function getUserId() {
        return $_SESSION['user']['id'];
    }
             
    public static function getAddWhereUser($status='published') {

        
        if ( !isset($_SESSION['user']['role']) )  {
                        
            $addWhere=" `status` >= ".POST_STATUS_PUBLISHED; 
            
        }                        

//        if ( $status=='published' ) {  $addWhere=" `status` >= ".POST_STATUS_PUBLISHED; }
                        
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
             $addWhere="   `author_id` = '{$_SESSION['user']['id']}'  and  
                          `status` = ".POST_STATUS_DELETED;          
            }
           
            
        elseif ($status=='deleted' AND $_SESSION['user']['role']=='admin') 

            { $addWhere=" `status` = ".POST_STATUS_DELETED;  }
           
            
            
        elseif ($status=='all' and $_SESSION['user']['role']=='user')
            {
             $addWhere=" ((`status` >= ".POST_STATUS_DELETED." and  `author_id` = '{$_SESSION['user']['id']}') or (`status` >= ".POST_STATUS_PUBLISHED."))";          
            }                


        elseif ($status=='all' AND $_SESSION['user']['role']=='admin') 

            { $addWhere=" `status` >= ".POST_STATUS_DELETED;  }
            
        else 

            { $addWhere=" `status` >= ".POST_STATUS_PUBLISHED;  }

        return $addWhere;    
    }

}
