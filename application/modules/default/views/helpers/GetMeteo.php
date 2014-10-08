<?php
class Zend_View_Helper_GetMeteo extends Zend_View_Helper_Abstract 
{
    public function getMeteo()
    {
        $clima = new Default_Model_Components_Meteo();
        $meteoRes = $clima->getMeteo();

        return $meteoRes;
        
        
       
    }
}