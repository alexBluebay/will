<?php

class Default_Model_Components_Linkuri {
    
    public function getLastLinkuri()   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->order(array( 'type DESC', 'id DESC' ))
                ->limit('4');
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    public function getPromoLinkuri()   
    {
        $dbTableLinkuri = new Default_Model_DbTable_PromoLinks();
                
        $select = $dbTableLinkuri->select()
                ->from(array( 'p' => 'admin_promo_links' ), array('*'))
                ->where("link_layout = ?", 'sponsorizate')
                ->order(array( 'link_order' ))
                ->limit('4');
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    public function getFooterLinks()   
    {
        $dbTableLinkuri = new Default_Model_DbTable_PromoLinks();
                
        $select = $dbTableLinkuri->select()
                ->from(array( 'p' => 'admin_promo_links' ), array('*'))
                ->where("link_layout = ?", 'footer')
                ->order(array( 'link_order' ));
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    
    public function getLinkuri($subcategorieId)   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'longDescription', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->where("categoryId = ?", $subcategorieId);
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    public function getExtraLinkuri($subcategorieId, $linkId)   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'longDescription', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->where("categoryId = ?", $subcategorieId)
                ->where("id != ?", $linkId)
                ->limit(4);
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    
    public function getDetaliuLink($linkId)
    {
        
        // select din tabela linkuri pe baza id-ului de link
        
        $dbTableDetaliuLink = new Default_Model_DbTable_Linkuri();
        
        $select = $dbTableDetaliuLink->select()
                ->from(array('l' => 'links'), array('id', 'categoryId', 'url', 'title', 'shortDescription', 'longDescription', 'status', 'type'))
                ->setIntegrityCheck(false)
                
                ->join(array('c' => 'categories'), 'l.categoryId = c.id', array('category as subcategory'))
                ->join(array('c2' => 'categories'), 'c.parentId = c2.id', array('category as category'))
                
                ->where('status = ?', 'Y')
                ->where('l.id = ?', $linkId);
        
        // ai un join cu tabela de categorii ca sa aflii si denumirea categoriei
        
        // la final nu uita sa faci fetchRow ca sa iei un singur rezultat
        
        $result = $dbTableDetaliuLink->fetchRow($select);
        
        return $result;
    }

    /**
     * - functie de adaugare link
     * @param array $postData
     * @return int - randul adaugat
     */
    public function insertLink($postData){
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
        
        // construiti array de insert manual
                
        $insert = array(
            'categoryId' => $postData['category'],
            'url' => $postData['url'],
            'title' => $postData['title'],
            'email' => $postData['email'],
            'shortDescription' => $postData['short'],
            'longDescription' => $postData['long'],
            'createdAt' => new Zend_Db_Expr('NOW()'),
            'ip' => $_SERVER['REMOTE_ADDR'],
        );
                        
        $insertId = $dbTableLinkuri->insert($insert);
       
        
        return $insertId;
    }
    
   
}
    