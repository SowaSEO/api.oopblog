<?php

/**
 * Description of Controllers
 *
 * @author User
 */
namespace base;

abstract class Controller {
    
//    protected $_view;
    
    public function __construct() {
//        
//        $this->_view = new View();
//        
//        $this->_view->setLayout('main');
        
    }

    abstract public function actionIndex();
    
//    
//    public function show404page(){
//
//        echo "<hr>Сторінка 404 <hr>";
//     
//        header("HTTP/1.1 404 Not Found");
//        header("Location: /page404");  
//       
//    die(' die 404');
//
//}
            
}
