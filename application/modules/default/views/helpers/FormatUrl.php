<?php
class Zend_View_Helper_FormatUrl extends Zend_View_Helper_Abstract 
{
    function FormatUrl($str, $delimiter='_', $replace=array()) {
        $nochartitle = array('`','~','!','$','&','_','=','{','}',':',';',',','.','/','\\','-','#','%','?','[',']','*','>','<','^', '(', ')', '"','\'');
        
        if( !empty($replace) ) {
         $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = str_replace($nochartitle, "-", $str);
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        //$clean = ucfirst(strtolower(trim($clean, '-')));
        $clean = trim($clean, '-');

        return $clean;
    }
}