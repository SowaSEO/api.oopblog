<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base;

//namespace core;
/**
 * Description of View
 *
 * @author User
 */

use library\Auth;

class View {
        
    public $basePath = __DIR__.'/../views/templates/';
    
    protected $title;
    protected $h1 = 'блог на ООП';
    protected $seo=[];
    protected $css=[];
    protected $js=[];
    
    protected $_layout;
    
    public function setLayout($layout) {   // макет
        $this->_layout = __DIR__.'/../views/layouts/'.$layout.'.php';
    }
    
    
    public function render($tplName, $data) {      
                
        if (isset($data['model'])) {
            $model= $data['model'];
        }
        
//        var_dump($models);
                
                
                
        include $this->_layout;                
    }

    public function setTitle($str) { 
        $this->title = $str ;
    }
    
    public function isAdmin() {
        return Auth::isAdmin();
    }

    public function setH1($str) {
        $this->h1 = $str ;
    }
    
    
    public function getTitle($str) {
        return $this->title;
    }
    
    public function setCss($css) {
        $this->css[] = $css;
    }
    
    
//    public function isAuth() {
//        
//        if (Auth::isGuest()) { 
//            return false ;
//            
//        } else { return ;}     
//    }
    //put your code here
}
