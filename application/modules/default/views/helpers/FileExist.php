<?php
class Zend_View_Helper_FileExist extends Zend_View_Helper_Abstract 
{
    function FileExist($filename, $filepath = 'default/img/uploads/') {
       
		if (file_exists($filepath.$filename.'.jpg')) {
		
			return $filepath.$filename.'.jpg';
			
		} else {
		
			return $filepath.'default.jpg';
			
		}
    }
}