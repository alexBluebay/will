<?php

class Admin_Model_Components_Links 
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function listLinks()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('*')) // vezi db si ia id titlu, url si link
                ->where("status = 'N'"); // active row name ??????
        $listThem = $dbTableLinks->fetchAll($select);
        
        return $listThem;
    }
    
    public function listAllLinks()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('*'));
        $listThem = $dbTableLinks->fetchAll($select);
        
        return $listThem;
    }
    
    

    
    public function getCategories()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                
                ->where("parentId IS NULL");
        
        $listThem = $dbTableLinks->fetchAll($select)->toArray();
        
        return $listThem;
    }
    
    
    public function getSubcategories()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                
                ->where("parentId IS NOT NULL");
        
        $listThem = $dbTableLinks->fetchAll($select)->toArray();
        
        return $listThem;
    }
    

    
    public function getCategoriesStructure()
    {
        $categoriesArr = $this->getCategories();
        $subcategoriesArr = $this->getSubcategories();
        
        
        $catResults = array();
        
        foreach($categoriesArr as $c) {
            $catResults[$c['category']] = array();
            
            foreach($subcategoriesArr as $s) {
                if($c['id'] == $s['parentId']) {
                    $catResults[$c['category']][$s['id']] = $s['category'];                    
                }
            }
        }
        
        return $catResults;
        
    }
    
    public function infoLinks($linkId)   
    {
        
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('*')) // vezi db si ia id titlu, url si link
                ->where('id = ?', $linkId);
        $listThem = $dbTableLinks->fetchRow($select);
        
        return $listThem;
    }
    
    public function getCategoryName($id)   
    {
        
        $dbTableCategory = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableCategory->select()
                ->from(array('c' => 'categories'), array('*')) // vezi db si ia id titlu, url si link
                ->where('id = ?', $id); // active row name ??????
        return $dbTableCategory->fetchRow($select);
    }
    
    public function updateLink($data, $idLink){
        $dbTableLinks = new Admin_Model_DbTable_Links();
        $updLink = $dbTableLinks->update(array(
            'categoryId' => $data['category'],
            'url' => $data['url'],
            'title' => $data['title'],
            'email' => $data['email'],
            'shortDescription' => $data['short'],
            'longDescription' => $data['long'],
            'type' => $data['type'],
            'status' => $data['status']
        ), "id = '$idLink'");
        
        return $updLink;
    }
    
    public function delLink($id){
        $dbTableLinks = new Admin_Model_DbTable_Links();

        $res = $dbTableLinks->delete(array(
            'id = ?' => $id
        ));
        
        return $res;
    }
}