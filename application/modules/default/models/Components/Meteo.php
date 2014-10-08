<?php

class Default_Model_Components_Meteo {
    
    public function getMeteo()   
    {
        $dbTableMeteo = new Default_Model_DbTable_Meteo();
                
        $select = $dbTableMeteo->select()
                ->from(array('m' => 'meteo'), array('city', 'temp', 'status'))
                ->where("status = ?", 'Y');
        
                                                         
        $results = $dbTableMeteo->fetchAll($select);                 
        return $results;
                
    }
}
    