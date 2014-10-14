<?php

class Default_Model_Components_AdvertisingModel {
    
    public function getAds($type = '')   
    {
        if ($type != ''){
            
            $dbTableAds = new Default_Model_DbTable_Advertising();

            $select = $dbTableAds->select()
                    ->from(array('a' => 'advertising'), array('*'))
                    ->where("layout = ?", $type)
                    ->order(new Zend_Db_Expr('RAND()'));


            $results = $dbTableAds->fetchRow($select);                 
            return $results;
        
        }
    }
}
    