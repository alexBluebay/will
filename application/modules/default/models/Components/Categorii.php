<?php

class Default_Model_Components_Categorii {
    
    public function getCategorii(){
        $dbTableCategorii = new Default_Model_DbTable_Categorii();
                
        $select = $dbTableCategorii->select()
                ->from(array('c' => 'categories'), array('id', 'category', 'description','parentId'))
                ->where('parentId IS NULL');
        
                                                         
        $results = $dbTableCategorii->fetchAll($select);
                                
        return $results;
                
    }
    
    public function getCategoriiExtra(){
        $dbTableCategorii = new Default_Model_DbTable_Categorii();
                
        $select = $dbTableCategorii->select()
                ->from(array('c' => 'categories'), array('*'));
        
                                                         
        $results = $dbTableCategorii->fetchAll($select)->toArray();
        
        $arr = array();
        foreach ($results as $row){
       
           if(!$row['parentId']) {
               $arr[$row['id']] = $row;
               
                foreach ($results as $row2){
                    if($row2['parentId'] && $row2['parentId'] == $row['id']) {
                        $arr[$row['id']]['subcategories'][] = $row2;
                    }
                }
               
           }
          
        }
       
                        
        return $results;
                
    }
    
    public function getSubCategorii($categorii){
         
        $dbTableSubCategorii = new Default_Model_DbTable_Categorii();
        
        $select = $dbTableSubCategorii ->select()
                ->from(array('c' => 'categories'), array('id', 'category', 'description'))
                ->where('parentId = ?' , $categorii);
        
        
        $results =$dbTableSubCategorii->fetchAll($select);
        
        return $results;
        
                        // 

    }
    public function getCategorii2()   
    {
        $dbTableLinks = new Default_Model_DbTable_Categorii();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                
                ->where("parentId IS NULL");
        
        $listThem = $dbTableLinks->fetchAll($select)->toArray();
        
        return $listThem;
    }

    public function getSubcategorii2()   
    {
        $dbTableLinks = new Default_Model_DbTable_Categorii();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                
                ->where("parentId IS NOT NULL");
        
        $listThem = $dbTableLinks->fetchAll($select)->toArray();
        
        return $listThem;
    }
    public function getCategoriiStructure()
    {
        $categoriesArr = $this->getCategorii2();
        $subcategoriesArr = $this->getSubcategorii2();
        
        
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
    
    
    
    /**
     * Preia categoria/subcategoria pe baza id-ului
     * @param int $id
     * @return categorie/subcategorie
     */
    public function getCategory($id) {
               
        $dbTableLinks = new Default_Model_DbTable_Categorii();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                ->setIntegrityCheck(false)
                ->joinLeft(array('cats2' => 'categories'), 'cats.parentId = cats2.id', array('category as categoryName'))
                
                
                ->where('cats.id = ?', $id);
        
        $result = $dbTableLinks->fetchRow($select);
        
        return (count($result)) ? $result : null;
                    
    }
    
    
    
    
}   