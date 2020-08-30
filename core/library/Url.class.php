<?php
/**
 * Description of url
 *
 * @author User
 */
namespace library;

class Url{

    protected static function getSegmentsFromUrl() {
        
        
        if (isset($_GET['url'])) {
            $segments = explode('/',$_GET['url']);
        }
        else $segments=[];
            if(empty($segments[count($segments)-1])) {
            
                unset($segments[count($segments)-1]);
        }
                
        $sements= array_map(function($v){ return preg_replace('/[\'\\\*]/','',$v); }, $segments) ;        
                   
        return $segments;
    }
 /**
 * @param int
 * 
 * @return string
 */

    public static function getParam($paramName) {
                
        return addslashes($_GET[$paramName]);
        
    } 
    
 /**
 * @param int
 * 
 * @return string null
 */
   public static function getSegment($n) {
                           
        $segments = self::getSegmentsFromUrl();  
        
        if ($n < count($segments) ) return $segments[$n];

   }
        
/**
 * @param int
 * 
 * @return string
 */
    
    public static function getAllSegments() {
        
        return self::getSegmentsFromUrl();;
    }
    
/**
 * @param 
 * 
 * @return string
 */

    public static function getCountGetParametres() {
               
        return count($_GET);
    }
/**
 * @param int
 * 
 * @return string
 */
    
    public static function getCountUrlSegments() {                
        
        return count(self::getAllSegments());
        
    }    
/**
 * @param 
 * 
 * @return string
 */    
    public static function getUrlSting() {
        
        return $_GET['url'];
        
    }    
    
}
