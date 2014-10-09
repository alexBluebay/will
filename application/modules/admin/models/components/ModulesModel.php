<?php

class Admin_Model_Components_ModulesModel
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function exchangeModuleList()   
    {
        $dbTableExchange = new Admin_Model_DbTable_CurrencyExchange();
        
        $select = $dbTableExchange->select()
                ->from(array('c' => 'currency_exchange'), array('*'))
                ->order('position ASC');
        
        $listThem = $dbTableExchange->fetchAll($select)->toArray();
        
        //$listThem = array_chunk($listThem, 5);
        
        
        
        return $listThem;
    }
    
    public function meteoModuleList()   
    {
        $dbTableMeteo = new Admin_Model_DbTable_Meteo();
        
        $select = $dbTableMeteo->select()
                ->from(array('m' => 'meteo'), array('*'))
                ->order('city');
        
        $listThem = $dbTableMeteo->fetchAll($select);
        
        return $listThem;
    }
    
    public function editCurr($data){   
        
        $dbTableExchange = new Admin_Model_DbTable_CurrencyExchange();
        
        $updCurr = $dbTableExchange->update(array(
            'active' => 'N'
        ), true);
                
        foreach ($data as $key => $value){
            $updCurr = $dbTableExchange->update(array(
                'active' => ($data[$key] == 1) ? 'Y' : 'N'
            ), "currencyIndex = '$key'");
        }
        return true;
        
    }
    
    public function editMeteo($data){   
        
        $dbTableMeteo = new Admin_Model_DbTable_Meteo();
        
        $updMeteo = $dbTableMeteo->update(array(
            'status' => 'N'
        ), true);
        
        foreach ($data as $key => $value){
            $updMeteo = $dbTableMeteo->update(array(
                'status' => ($data[$key] == 1) ? 'Y' : 'N'
            ), "id = '$key'");
        }
        return true;
        
    }
    
    
    public function updateCurrencyPosition ($data) {
        
        $tableCurrencyDbTable = new Admin_Model_DbTable_CurrencyExchange();

        $tableCurrencyDbTable->update(array(
            'position' => 9999
        ), true);

        $i = 1;
        foreach($data as $currencyId) {

            $tableCurrencyDbTable->update(array(
                'position' => $i
            ), array(
                'id = ?' => $currencyId
            ));

            $i++;
        }
        
    }
    
    
    public function updateMeteoPosition ($data) {
        
        $tableMeteoDbTable = new Admin_Model_DbTable_Meteo();

        $tableMeteoDbTable->update(array(
            'order' => 9999
        ), true);

        $i = 1;
        foreach($data as $meteoId) {

            $tableMeteoDbTable->update(array(
                'order' => $i
            ), array(
                'id = ?' => $meteoId
            ));

            $i++;
        }
        
    }
    
    public function cronExchangeList()   
    {
        $dbTableExchange = new Admin_Model_DbTable_CurrencyExchange();
        
        $select = $dbTableExchange->select()
                ->from(array('c' => 'currency_exchange'), array('*'))
                ->where("active = 'Y'")
                ->order('position ASC');
        
        $listThem = $dbTableExchange->fetchAll($select);
        
        $exModel = new Admin_Model_Components_ExchangeModel();
        $exModel->cursBnrXML();
        
        // echo $exModel->date
        
        foreach ($listThem as $x) {
            
         $dbTableExchange->update(array(
                'value' => $exModel->getCurs($x->currencyIndex)
                ), array(
                    'id = ?' => $x->id
                ));
         
        }
        
        
        
        return $listThem;
    }
    
    public function cronMeteoModel(){
        
        $tableMeteoDbTable = new Admin_Model_DbTable_Meteo();
        
        $select = $tableMeteoDbTable->select()
                ->from(array('m' => 'meteo'), array('*'))
                ->where("status = 'Y'")
                ->order('order ASC');
        
        $listThem = $tableMeteoDbTable->fetchAll($select);
        
        foreach($listThem as $m){
            
            $meteoLink = file_get_contents('http://www.vremea.com/cgi-bin/metar.cgi?template=public.htm&icao='.$m->service_id);
       
            if (preg_match("/Temperatura: <b>(\d+)[^<+]/s", $meteoLink, $matches1)) {
               $temp = $matches1[1];
                //$temp = preg_replace('/[^0-9]/', '', $matches1[1]); 
                $tableMeteoDbTable->update(array(
                        'temp' => $temp,
                        'modifiedAt' => new Zend_Db_Expr('now()')
                    ), array(
                        'id = ?' => $m->id
                    ));
                
            }
        }
        
        return $listThem;        
    }
    
}