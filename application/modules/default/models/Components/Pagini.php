<?php

class Default_Model_Components_Pagini {
    
    public function getPagini()   
    {
        $dbTablePagini = new Default_Model_DbTable_Pagini();
                
        $select = $dbTablePagini->select()
                ->from(array('l' => 'pages'), array('pageType', 'content', 'metaTitle', 'metaDescription', 'metaKeywords'))
                ->where('content IS NOT NULL');
        
                                                         
        $results = $dbTablePagini->fetchAll($select);
                                
        return $results;
                
    }
}
    