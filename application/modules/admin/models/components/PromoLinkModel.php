<?php

class Admin_Model_Components_PromoLinkModel
{
   public function enumBuildSelect()   
    {
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
               
        return $dbTablePromoLinks->getEnumValuesLinkLayout();
    }
    
    public function listPromoLinks()   
    {
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
        
        $select = $dbTablePromoLinks->select()
                ->from(array('p' => 'admin_promo_links'), array('*'))
                ->order(array('link_layout', 'link_order'));
        
        $listThem = $dbTablePromoLinks->fetchAll($select);
        
        return $listThem;
    }
    
    public function editPromoLink($idLink){
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
        
        $select = $dbTablePromoLinks->select()
                ->from(array('p' => 'admin_promo_links'), array('*'))
                ->where('p.id = ?', $idLink);
        $listRow = $dbTablePromoLinks->fetchRow($select);
        
        return $listRow;
    }
    
    public function addPromoLink($data){
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
        $linkId = $dbTablePromoLinks->insert(array(
            'title' => $data['title'],
            'url' => $data['url'],
            'link_layout' => $data['layout'],
            'desc' => $data['desc']
        ));
        
        return $linkId;
    }
    
    public function updatePromoLink($data, $idLink){
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
        $updLink = $dbTablePromoLinks->update(array(
            'title' => $data['title'],
            'url' => $data['url'],
            'link_layout' => $data['layout'],
            'desc' => $data['desc']
        ), "id = '$idLink'");
      
        return $idLink;
    }
    
    public function delPromoLink($id){
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();

        $res = $dbTablePromoLinks->delete(array(
            'id = ?' => $id
        ));
        
        return $res;
    }
    
    public function updatePromoPosition ($data) {
        
        $dbTablePromoLinks = new Admin_Model_DbTable_AdminPromoLinks();
        
        $dbTablePromoLinks->update(array(
            'link_order' => 99
        ), true);

        $i = 1;
        foreach($data as $promoId) {

            $dbTablePromoLinks->update(array(
                'link_order' => $i
            ), array(
                'id = ?' => $promoId
            ));

            $i++;
        }
        
    }
    
}