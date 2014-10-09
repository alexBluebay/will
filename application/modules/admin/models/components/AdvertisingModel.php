<?php

class Admin_Model_Components_AdvertisingModel
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function listAdvertising()   
    {
        $dbTableAdv = new Admin_Model_DbTable_Advertising();
        
        $select = $dbTableAdv->select()
                ->from(array('a' => 'advertising'), array('*'))
                ->order('layout');
        
        $listThem = $dbTableAdv->fetchAll($select);
        
        return $listThem;
    }
    
    public function editAdvertisings($idAdv){
        $dbTableAdv = new Admin_Model_DbTable_Advertising();
        
        $select = $dbTableAdv->select()
                ->from(array('a' => 'advertising'), array('*'))
                ->where('a.id = ?', $idAdv);
        $listCat = $dbTableAdv->fetchRow($select);
        
        return $listCat;
    }
    
    public function AdvertisingBuildSelect()   
    {
        $dbTableAdv = new Admin_Model_DbTable_Advertising();
        
        //print_r($dbTableAdv->getEnumValuesLayout());
        
        //$db = Zend_Db_Table::getDefaultAdapter();                        
        //$stmt = $db->query("SHOW COLUMNS FROM advertising WHERE Field = 'layout'");
        //$r = $stmt->fetchAll();
        
        return $dbTableAdv->getEnumValuesLayout();
    }
    
    public function updateAdvertising($data, $idAdv){
        $dbTableAdv = new Admin_Model_DbTable_Advertising();
        $updLink = $dbTableAdv->update(array(
            'title' => $data['title'],
            'layout' => $data['layoutType'],
            'adv_code' => $data['advCode']
        ), "id = '$idAdv'");
      
        return $idAdv;
    }
    
    public function addAdvertising($data){
        $dbTableAdv = new Admin_Model_DbTable_Advertising();
        $linkId = $dbTableAdv->insert(array(
            'title' => $data['title'],
            'layout' => $data['layoutType'],
            'adv_code' => $data['advCode']
        ));
        
        return $linkId;
    }
    
    public function delAdvertising($id){
        $dbTableAdv = new Admin_Model_DbTable_Advertising();

        $res = $dbTableAdv->delete(array(
            'id = ?' => $id
        ));
        
        return $res;
    }
    
}