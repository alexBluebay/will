<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initSession()
    {
        new Zend_Session_Namespace();             
    }
    
    public function _initLocalTime(){
        setlocale(LC_TIME, 'ro_RO', 'rom_rom');
    }
    
	
	
    public function _initSetDbAdapter()
    {
        $config = new Zend_Config(
            array(
                'database' => array(
                    'adapter' => 'pdo_mysql',
                    'params'  => array(
                        'host'     => '87.230.18.245',
                        'dbname'   => 'bluebay_will',
                        'username' => 'bluebay_will',
                        'password' => 'parola123#',
                    )
                )
            )
        );
        
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table::setDefaultAdapter($db);
        
        
        
//        $config = new Zend_Config(
//            array(
//                'database' => array(
//                    'adapter' => 'pdo_mysql',
//                    'params'  => array(
//                        'host'     => 'localhost',
//                        'dbname'   => 'bluebay_will',
//                        'username' => 'root',
//                        'password' => '',
//                    )
//                )
//            )
//        );
//        
//        $db = Zend_Db::factory($config->database);
//        Zend_Db_Table::setDefaultAdapter($db);
    }

    
    
    
    
    
    
    
}

