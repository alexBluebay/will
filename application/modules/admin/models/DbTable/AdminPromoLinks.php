<?php
class Admin_Model_DbTable_AdminPromoLinks extends Zend_Db_Table_Abstract 
{
    protected $_name = 'admin_promo_links';
    
    public function getMetaData()
    {
        $data = $this->info(self::METADATA);
        return $data;
    }
    
    public function getEnumValuesLinkLayout()
    {
        $metadata = $this->getMetaData();
       
        $str = $metadata['link_layout']['DATA_TYPE'];
        
        $str = ltrim($str, 'enum('); $str = rtrim($str, ')');
        $str = str_replace("'", '', $str);
        $arr = explode(',', $str);
        $arr = array_combine(array_values($arr), array_values($arr));
        
        return $arr;
        
    }
}