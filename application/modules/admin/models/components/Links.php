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
    
    
    public function listAllLinks($paginationArr = array(), $spec = array())   
    {
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
                 
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('id as linkId', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'picture', 'createdAt', 'status', 'type', 'ip'))
                ->order('l.id DESC');
        
        if (isset($paginationArr['maxPePag']) && isset($paginationArr['offsetStart'])) {
            $select->limit($paginationArr['maxPePag'], $paginationArr['offsetStart']);
        }
        
        if (isset($spec['category']) && ($spec['category'] != '')){
            $select->where('categoryId = ?', $spec['category']);
        }
        
        if (isset($spec['type']) && ($spec['type'] != '')){
            $select->where('type = ?', $spec['type']);
        }
        
        if (isset($spec['search']) && ($spec['search'] != '')){
            $select->where('title LIKE ?', "%{$spec['search']}%");
        }
        
        if (isset($spec['keys']) && ($spec['keys'] != '')){
            $select->setIntegrityCheck(false) 
            ->group(array('l.id'))
            ->join(array('lk' => 'links_keywords'), 'lk.urlId = l.id')
            ->join(array('z' => 'keywords'), 'z.id = lk.keywordId');
            
            $keyExplode = explode(',', $spec['keys']);
            
            if(count($keyExplode) == 1) {
                $select->where('z.keyword = ?', trim($keyExplode[0]));
            }      
            else {
                $syntax = '';
                foreach ($keyExplode as $key) {
                    $syntax .= $db->quoteInto('z.keyword=?', $key) . ' OR ';
                }           
                $syntax = rtrim($syntax, 'OR ');   
                                
                $select->where($syntax);
            }
                    
        }
        
       
            
        $listThem = $dbTableLinks->fetchAll($select);
        
        return $listThem;
    }
    
    
    public function countListAllLinks()   
    {
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('count(id) as count'));
        
                
        $cnt = $dbTableLinks->fetchRow($select);
        
        return $cnt->count;
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
    
    public function linkTypeStructure(){
        
        $dbTableLinks = new Admin_Model_DbTable_Links();
        
        return $dbTableLinks->getEnumValuesType();
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
        
        $select = $dbTableLinks->select()
                ->from(array('l' => 'links'), array('picture')) // vezi db si ia id titlu, url si link
                ->where('id = ?', $id);
        $queryRes = $dbTableLinks->fetchRow($select);

        $res = $dbTableLinks->delete(array(
            'id = ?' => $id
        ));
        
        if (file_exists('default/img/uploads/'.$queryRes->picture)) {
            unlink('default/img/uploads/'.$queryRes->picture);
        }
        
        return $res;
    }
}