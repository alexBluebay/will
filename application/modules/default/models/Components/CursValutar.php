<?php

class Default_Model_Components_CursValutar {
    
    public function getCursValutar()   
    {
        $dbTableCursValutar = new Default_Model_DbTable_CursValutar();
                
        $select = $dbTableCursValutar->select()
                ->from(array('cv' => 'currency_exchange'), array('currencyName', 'currencyIndex', 'active', 'value'))
                ->where("active = 'Y'");
        
                                                         
        $results = $dbTableCursValutar->fetchAll($select);
                                
        return $results;
                
    }
}
    