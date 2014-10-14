<?php
class Zend_View_Helper_GetAds extends Zend_View_Helper_Abstract 
{
    public function GetAds($type)
    {
        $adsModel = new Default_Model_Components_AdvertisingModel();
        $ads = $adsModel->getAds($type); // top, links, nav_left, col_left, col_right, footer

        return $ads;
        
        
       
    }
}