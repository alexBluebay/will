<?php

class Admin_Model_Components_PagesModel
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function listPages()   
    {
        $dbTablePages = new Admin_Model_DbTable_Pages();
        
        $select = $dbTablePages->select()
                ->from(array('p' => 'pages'), array('*'));
        
        $listThem = $dbTablePages->fetchAll($select);
        
        return $listThem;
    }
    
    public function editPages($idPage){
        $dbTablePages = new Admin_Model_DbTable_Pages();
        
        $select = $dbTablePages->select()
                ->from(array('p' => 'pages'), array('*'))
                ->where('p.id = ?', $idPage);
        $listCat = $dbTablePages->fetchRow($select);
        
        return $listCat;
    }
    
    public function PagesBuildSelect()   
    {
        $dbTablePages = new Admin_Model_DbTable_Pages();
        
        return $dbTablePages->getEnumValuesLayout();
    }
    
    public function updatePages($data, $idPage){
        $dbTablePages = new Admin_Model_DbTable_Pages();
        $updLink = $dbTablePages->update(array(
            'pageType' => $data['type'],
            'content' => $data['pageContent'],
            'metaTitle' => $data['metaTitle'],
            'metaDescription' => $data['descriptionMeta'],
            'metaKeywords' => $data['metaKeys'],
        ), "id = '$idPage'");
      
        return $idPgs;
    }
    
}