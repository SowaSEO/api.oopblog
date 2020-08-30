<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('SECRETKEY','sU1bo1ta');

define('POST_FOR_PAGE',5);

define('POST_STATUS_MODERATION',0);

define('POST_STATUS_PUBLISHED',11);

define('POST_STATUS_DELETED',-10);

const  TEXTSTATUS = [
    POST_STATUS_MODERATION => 'На модерації',
    POST_STATUS_PUBLISHED => 'Опубліковано',
    POST_STATUS_DELETED => 'Видалено'    
];