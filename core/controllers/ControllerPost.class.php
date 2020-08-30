<?php

/* API.oopBlog.mvc
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controllers;

/**
 * ОбробляЄ URI 
 *
 * @author User
 */

use base\Controller;

//use library\Db;

use library\Auth;

use library\HttpException;

use library\Url;

use models\Post;

use models\PostForm;

use library\Request;


class ControllerPost extends Controller{
                   
    public function actionIndex() {
                                               
        if (!$this->isUriPostOK() ) {
            
           $this->apiesult(404,['status' => false]);           
        }
                   
        $IdPost=Url::getSegment(1);
        
        if ($IdPost=='add' AND Request::isPost() ) {
            
         $this->actionAddpost();
         
     }
         elseif($IdPost!='add' AND  Request::isGet()) {   
             
            $model = new Post($IdPost);
            
            echo json_encode($model->post);                                 
            
         }                 
    }
                   
    public function actionAddpost() {
                 
        $res=[
                'status' => False,
                'postId' => 0
              ];
        
        $res_code=417;
                
        if (!Auth::isGuest()) {
            
            $model= new PostForm();
            $model->load(Request::getPost());
            
            if($model->load(Request::getPost()) and $model->validate())
            {                    
                if($model->save()){
                    unset($_POST);
                    // повертаэмо id pfgbce  
                    
                    $res=[
                        'status' => TRUE,
                        'postId' => $model->id
                    ];
                    
                    $this->apiesult(201,$res) ;
                }
                    $res_code=424;
            }                                                                                                                         
        }        
        
        $this->apiesult($res_code,$res) ;
     }
             
     public function isUriPostOK() {
                    // перевіряэмо          
        $Segment2 = Url::getSegment(1); 
            
        if ( $Segment2>0 or $Segment2 =='all' or $Segment2 =='add'){
             
            return True ;                     
        } 
         return false;         
     }
             
    public function apiesult($res_code,$res) {
        
        header('content_type: json/application');
        
        http_response_code($res_code);
        
        echo json_encode($res);
        
        die();       
    }
    
}
