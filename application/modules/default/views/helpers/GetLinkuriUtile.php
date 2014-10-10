<?php
class Zend_View_Helper_GetLinkuriUtile extends Zend_View_Helper_Abstract 
{
    public function GetLinkuriUtile()
    {
        $linkModel = new Default_Model_Components_Linkuri();
        $utile = $linkModel->getLinkuriUtile();

        return $utile;
        
        
       
    }
}