<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

/**
 * Description of post
 *
 * @author User
 */

use library\Db;

use base\BaseForm;

use library\HttpException;

class post extends BaseForm{
    
    public $id;
    public $title;
    public $content;
    public $author;
    public $pubdate;
    public $post;
    
    protected $_db;
        
    public function __construct($id) {
                                                   
        $this->_db= Db::getDb();
            
        if  ($id>1) {   // один пост за номером 
          
            $addWhere=" `post`.`id`=$id  and ".$this->getAddWhereByStatus('all');
            
        } elseif ($id=='all') { //  всі пости
            
            $addWhere=$this->getAddWhereByStatus('all');
            
        } 
                    
        $sql ="SELECT `post`.`id` as `id`,`author_id`,`headline`,`description`,`title`,`content`,`datapub`,`status`, `user`.`nickname`, `user`.`pib`  FROM post LEFT JOIN user ON post.author_id = user.id  WHERE $addWhere";

        $res =$this->_db->sendSelectQuery($sql);
                    
        if($res->num_rows == 0) { 
                                            
            throw new HttpException('Not POST Found', '404');                        
            
        }  else {
        
            $this->post = mysqli_fetch_all($res,MYSQLI_ASSOC);
        }
    }
    
    
     public function getRules() {
        return[                                    
            'title'=> ['required','unique'],
            'content'=>['required']            
        ];                
   }
                         
    public function moderatiON($idPost){       
        $sql="UPDATE `post` SET `status`= ".POST_STATUS_PUBLISHED." WHERE `id`=$idPost";
        $this->_db->sendSelectQuery($sql);    
    }

    public function deletedON($idPost){     
        $sql="UPDATE `post` SET `status`= ".POST_STATUS_DELETED." WHERE `id`=$idPost";
        $this->_db->sendSelectQuery($sql);
    }
 
}
