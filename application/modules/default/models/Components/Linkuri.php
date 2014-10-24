<?php

class Default_Model_Components_Linkuri {
    
    public function getLastLinkuri()   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'picture', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->order(array( 'createdAt DESC' ))
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
    
    public function getLinkuri($subcategorieId, $spec = array())   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'longDescription', 'picture', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->where("categoryId = ?", $subcategorieId)
                
                ->order(array('type DESC', 'createdAt DESC'));
				
		
                
        
        if(isset($spec['offsetStart']) && isset($spec['maxPePag'])) {
            $select->limit($spec['maxPePag'], $spec['offsetStart']);
        }
           
     
                
        $results = $dbTableLinkuri->fetchAll($select);  
                        
        return $results;
                
    }
    
    public function getCountLinks($subcategorieId)   
    {
         
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( 'l' => 'links' ), array('count(id) as count'))
                ->where("status = ?", 'Y')
                ->where("categoryId = ?", $subcategorieId);
                
        $results = $dbTableLinkuri->fetchRow($select);
         
        return $results->count;
                
    }
    
    public function getExtraLinkuri($subcategorieId, $linkId)   
    {
        $dbTableLinkuri = new Default_Model_DbTable_Linkuri();
                
        $select = $dbTableLinkuri->select()
                ->from(array( '1' => 'links' ), array('id', 'categoryId', 'url', 'title', 'email', 'shortDescription', 'longDescription', 'picture', 'status', 'type'))
                ->where("status = ?", 'Y')
                ->where("categoryId = ?", $subcategorieId)
                ->where("id != ?", $linkId)
                ->limit(4);
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    /**
     * 
     * @param int $linkId
     * @return array - detaliu link
     * @throws Exception
     */
    public function getDetaliuLink($linkId)
    {
        
        // select din tabela linkuri pe baza id-ului de link
        
        $dbTableDetaliuLink = new Default_Model_DbTable_Linkuri();
        
        $select = $dbTableDetaliuLink->select()
                ->from(array('l' => 'links'), array('id', 'categoryId', 'url', 'title', 'shortDescription', 'longDescription', 'picture', 'status', 'type'))
                ->setIntegrityCheck(false)
                
                ->join(array('c' => 'categories'), 'l.categoryId = c.id', array('category as subcategory'))
                ->join(array('c2' => 'categories'), 'c.parentId = c2.id', array('category as category'))
                
                ->where('l.id = ?', $linkId);
        
        if (!isset($_SESSION['tempId']) || ($_SESSION['tempId'] != $linkId)) {
            $select->where('status = ?', 'Y');
            
        }
      
        // ai un join cu tabela de categorii ca sa aflii si denumirea categoriei
        
        // la final nu uita sa faci fetchRow ca sa iei un singur rezultat
        
        $result = $dbTableDetaliuLink->fetchRow($select);
       
        if( !count($result) ) {
            throw new Exception('Nu exista link.');
        }
        
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
        
        if (strpos($postData['url'], 'http://') === false) {
            $postData['url'] = 'http://'.$postData['url'];
            
        }
        
        $insert = array(
            'categoryId' => $postData['category'],
            'url' => $postData['url'],
            'title' => $postData['title'],
            'email' => $postData['email'],
            'shortDescription' => $postData['short'],
            'longDescription' => $postData['long'],
            'createdAt' => new Zend_Db_Expr('NOW()'),
            'type' => ($postData['linkType'] == '1') ? 'exchange' : 'basic',
            'ip' => $_SERVER['REMOTE_ADDR'],
        );
                        
        $insertId = $dbTableLinkuri->insert($insert);
        
        $_SESSION['tempId'] = $insertId;
        
        
        
        $keyArr = explode(',', $postData['keywords']);
        
        if ($keyArr){
            
            $keywordTable = new Default_Model_DbTable_Keywords();
            $linkKeywordsTable = new Default_Model_DbTable_LinksKeyword();
            //print_r($keyArr); exit;
            
            foreach ($keyArr as $k) {
                $k = trim($k);
                $keyId = $this->checkIfKeyExist($k);
                $insertKey = array(
                    'keywordId' => $keyId,
                    'urlId' => $insertId
                );
                
                $linkKeywordsTable->insert($insertKey);
            }
            
        }
        
        try {
        
            require APPLICATION_PATH . '/../library/GrabzPicture/lib/GrabzItClient.class.php';

            $grabzIt = new GrabzItClient("ZWQ2MTdkNTEzOWFlNDlhNTllMTk2MDdiY2Q0MGZkMmI=", 
                                                                     "Pz8/Kz96Pz8/PzU/P3s/NDU/P0MdPz8AV1U/Pz8/Pz8=");

            $grabzIt->TakePicture($postData['url'], 
                            $_SERVER['HTTP_HOST'].'/index/grabz-it', 
                            $insertId, 
                            null, 
                            null, 
                            '100', 
                            '75',
                            'jpg'
                            );
        }
	catch (Exception $e) {
            //echo '';
	}
        return $insertId;
    }
    
    private function checkIfKeyExist($k){
        $keywordTable = new Default_Model_DbTable_Keywords();
            
            $select = $keywordTable->select()
                    ->from(array('z' => 'keywords'), array('*'))
                    ->where('keyword = ?', $k);
            $resKeyId = $keywordTable->fetchRow($select);
            
            if (count($resKeyId)) {
                //iau id
                $keyId = $resKeyId->id;
            } else {
                // insert
                
                $insertKey = array(
                    'keyword' => $k
                );
                
                $keyId = $keywordTable->insert($insertKey);
            }
            
            return $keyId;
    }
    
    public function getLinkuriUtile(){
        
        $dbTableLinkuri = new Default_Model_DbTable_PromoLinks();
                
        $select = $dbTableLinkuri->select()
                ->from(array( 'p' => 'admin_promo_links' ), array('*'))
                ->where("link_layout = ?", 'linkuriUtile')
                ->limit('4');
                
        $results = $dbTableLinkuri->fetchAll($select);
                              
        return $results;
                
    }
    
    public function updatePicture($id){
        if (isset($id) && $id != ''){
            $dbTableLinks = new Default_Model_DbTable_Linkuri();
            $updLink = $dbTableLinks->update(array(
                'picture' => $id.'.jpg'
            ), array(
                "id = ?" => $id
            ));
                   

            return $updLink;
        }
    }
    
    public function checkLinkExchange($url = ''){
        $backLinkArr = array(
            '<a href="http://www.will.ro" title="Director web Will.ro" target="_blank">will.ro - director online</a>',
            '<a href="http://www.will.ro" title="Director web Will.ro" target="_blank"><img src="http://www.will.ro/logo.jpg" alt="Director web Will.ro" border="0"></a>'
        );
        
        if (strpos($url, 'http://') === false) {
            $url = 'http://'.$url;
            
        }
        
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 1200, // 1 200 Seconds = 20 Minutes
            )
        ));
        
        $page = file_get_contents($url, false, $ctx);
        
        foreach ($backLinkArr as $as){
            if(strpos($page, $as) !== FALSE){
                return true;
            }
        }
        return false;
    }
   
}
    