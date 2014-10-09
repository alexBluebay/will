<?php

class Admin_Model_Components_PreDispatch extends Zend_Controller_Plugin_Abstract
{
    
    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        $actionNAme = $request->getActionName();
        
        
        $authClass = new Admin_Model_Components_AuthModel();
        
        if(!$authClass->logged()) {
           // echo 'okkkk'; exit;
        
        if($moduleName != 'admin' || 
                ($moduleName == 'admin' && $controllerName == 'index' && $actionNAme == 'index') )
            return;
        // daca clasa de autentificare arata ca utilizatoru nu este logat faci redirect catre login admin
        
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                
            $redirector->gotoSimple('index', 'index', 'admin');

        }
        
        
        
        // daca este autentificat intorci true;
    }
    
}