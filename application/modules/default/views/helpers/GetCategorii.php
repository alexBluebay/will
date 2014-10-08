<?php
class Zend_View_Helper_GetCategorii extends Zend_View_Helper_Abstract 
{
    public function getCategorii()
    {
        $mCat = new Default_Model_Components_Categorii();
        $cats = $mCat->getCategorii();

        return $cats;
        
        
       
    }
}