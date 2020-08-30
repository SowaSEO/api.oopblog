<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

/**
 * Description of PostForm
 *
 * @author User
 */

use base\BaseForm;

use library\Auth;


class PostForm extends BaseForm{
              
    public $id;
    public $headline;
    public $title;
    public $description;
    public $content;
  
    protected $_tableName ='post';
        
    public function getRules() {
        return[            
            'headline'=>['required'],
            'title'=> ['required'],
            'description'=>['required'],
            'content'=>['required']
        ];
    }
    
    
    
    public function getInitialPost($id) {
        
          if ($id>1) {
            
            $this->_db= Db::getDb();

            $addWhere='and'.\library\Auth::getAddWhereUser('all');

            $sql ="SELECT `post`.`id` as `id`,`author_id`,`headline`,`description`,`title`,`content`,`datapub`,`status`, `user`.`nickname`, `user`.`pib`  FROM post LEFT JOIN user ON post.author_id = user.id  WHERE `post`.`id`=$id $addWhere";

            $res =$this->_db->sendSelectQuery($sql);
    
        }
                
        if($res->num_rows == 0) {
                    
            throw new HttpException('Not POST Found', '404');                        
        }      
                
        $this->post = $res->fetch_assoc();                
    }
    
    
    public function save(){
        
        $author_id=Auth::getUserId();
        
        $sql="INSERT INTO {$this->_tableName} (`headline`,`title`,`description`,`content`,`author_id`) VALUES ('{$this->headline}','{$this->title}','{$this->description}','{$this->content}',{$author_id} )";
                        
        $res= $this->_db->sendSelectQuery($sql);
        
        if (!$res){
            
            $this->_errors['saveError'] = ' Error';
            
            return false;
        }
            
        $this->id = $this->_db->getLastInsertId();        
        
        return true ;                
    }    
    
    public function update() {
        
        $sql = "UPDATE {$this->_tableName} SET title = '{$this->title}', content='{$this->content}' WHERE id = {$this->id}  ";
        
        $res=$this->_db->sendQuery($sql);
        
        if(!$res) {
            
            $this->_errors['updateError'] = 'Error!';
            
            return false;
        }
        return true;
    }
    
    public function delete() {
        
        $sql = "DELETE FROM {$this->_tableName} WHERE id={$this->id} ";
        
        $res=$this->_db->sendInsUpDelQuery($sql);
        
        if(!$res){
            
            $this->_errors['deleteError']='Errorr!';
            
            return false;
            
        }
                return true;

    }
                               
    public function moderatiON($idPost){       
        $sql="UPDATE `post` SET `status`= ".POST_STATUS_PUBLISHED." WHERE `id`=$idPost";
        $this->_db->sendSelectQuery($sql);    
    }

    public function deletedON($idPost){     
        $sql="UPDATE `post` SET `status`= ".POST_STATUS_DELETED." WHERE `id`=$idPost";
        $this->_db->sendSelectQuery($sql);
    }
    
    //put your code here
}
