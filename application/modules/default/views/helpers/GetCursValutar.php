<?php
class Zend_View_Helper_GetCursValutar extends Zend_View_Helper_Abstract 
{
    public function getCursValutar()
    {
        $curs = new Default_Model_Components_CursValutar();
        $cv = $curs->getCursValutar();

        return $cv;
        
        
       
    }
}