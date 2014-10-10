<?php

class Default_Model_Components_Sponsor {
    
    public function getSponsorLink($id)
    {
        $dbTableSponsor = new Default_Model_DbTable_PromoLinks();
        $select = $dbTableSponsor->select()
                ->from(array('l' => 'admin_promo_links'), array('id','title','url','link_layout','desc'))
                ->where('link_layout = ?', 'sponsorizate')
                ->where('id != ?', $id)
                ->limit('4');
                        
                
        
        $result = $dbTableSponsor->fetchAll($select);
        
        return $result;
    }
    
    public function getSponsorInfo($id)
    {
        $dbTableSponsor = new Default_Model_DbTable_PromoLinks();
        
        $select = $dbTableSponsor->select()
                ->from(array('l' => 'admin_promo_links'), array('id','title','url','link_layout','desc'))
                ->where('id = ?', $id);
        
        $result = $dbTableSponsor->fetchRow($select);
        
        return $result;
    }
}