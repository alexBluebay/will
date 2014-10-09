<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

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
    }

    
    
    
    
    
    
    
}

