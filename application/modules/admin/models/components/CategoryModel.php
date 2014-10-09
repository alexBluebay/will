<?php

class Admin_Model_Components_CategoryModel 
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function listSubcats()   
    {
        $dbTableCat = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableCat->select()
                ->from(array('c' => 'categories'), array('id' ,'category as subcategory'))
                ->setIntegrityCheck(false)
                
                ->join(array('c2' => 'categories'), 'c.parentId = c2.id', array('category'))
                ->where('c.parentId IS NOT NULL')
                ->order(array('c2.category', 'c.category'));
        
        $listThem = $dbTableCat->fetchAll($select);
        
        return $listThem;
    }
    
    
    public function getCategoriesAll()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*'))
                //->setIntegrityCheck(false)
                
                //->joinLeft(array('cats2' => 'categories'), 'cats.parentId = cats2.id', array('category as subcategory'))
                ->order(array('parentId', 'category'));
               
        
        $listThem = $dbTableLinks->fetchAll($select)->toArray();
        
        return $listThem;
    }
    
    public function editCategory($idCat){
        $dbTableCat = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableCat->select()
                ->from(array('c' => 'categories'), array('*'))
                ->where('c.id = ?', $idCat);
        $listCat = $dbTableCat->fetchRow($select);
        
        return $listCat;
    }
    
    public function CategoriesBuildSelect()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Categories();
        
        $select = $dbTableLinks->select()
                ->from(array('cats' => 'categories'), array('*')) 
                
                ->where("parentId IS NULL");
        
        $listThem = $dbTableLinks->fetchAll($select);
        
        $arr = array();
        
        foreach($listThem as $c){
           $arr[$c->id] = $c->category;
        }
        
        return $arr;
    }
    
    public function updateCategory($data, $catId){
        $dbTableCats = new Admin_Model_DbTable_Categories();
        $updLink = $dbTableCats->update(array(
            'category' => $data['CatName'],
            'description' => $data['description'],
            'parentId' => ($data['category']) ? $data['category'] : null
        ), "id = '$catId'");
        
        return $updLink;
    }
    
    public function addCategory($data){
        $dbTableCats = new Admin_Model_DbTable_Categories();
        $catId = $dbTableCats->insert(array(
            'category' => $data['CatName'],
            'description' => $data['description'],
            'parentId' => ($data['category']) ? $data['category'] : null
        ));
        
        return $catId;
    }
    
    public function delCategory($id){
        
        $dbTableCats = new Admin_Model_DbTable_Categories();
                  
        try {
            $res = $dbTableCats->delete(array(
                'id = ?' => $id
            ));
        }
        catch(Exception $e) {
            throw new Exception("Categoria nu poate fi stearsa. Contine subcategorii!");
        }

        return $res;
                       
    }
    
}