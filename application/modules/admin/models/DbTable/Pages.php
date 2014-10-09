<?php
class Admin_Model_DbTable_Pages extends Zend_Db_Table_Abstract 
{
    protected $_name = 'pages';
    
    public function getMetaData()
    {
        $data = $this->info(self::METADATA);
        return $data;
    }
    
    public function getEnumValuesLayout()
    {
        $metadata = $this->getMetaData();
       
        $str = $metadata['pageType']['DATA_TYPE'];
        
        $str = ltrim($str, 'enum('); $str = rtrim($str, ')');
        $str = str_replace("'", '', $str);
        $arr = explode(',', $str);
        $arr = array_combine(array_values($arr), array_values($arr));
        
        return $arr;
        
    }
    
}