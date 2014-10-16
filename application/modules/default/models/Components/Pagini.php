<?php

class Default_Model_Components_Pagini {
    
    public function getPagini($layout)   
    {
        $dbTablePagini = new Default_Model_DbTable_Pagini();
                
        $select = $dbTablePagini->select()
                ->from(array('l' => 'pages'), array('pageType', 'content', 'metaTitle', 'metaDescription', 'metaKeywords'))
                ->where('pageType = ?', $layout);
        
                                                         
        $results = $dbTablePagini->fetchRow($select);
                                
        return $results;
                
    }
}
    