<?php
class Zend_View_Helper_GetFooterLinks extends Zend_View_Helper_Abstract 
{
    public function GetFooterLinks()
    {
        $linkModel = new Default_Model_Components_Linkuri();
        $footerLinks = $linkModel->getFooterLinks();

        return $footerLinks;
        
        
       
    }
}