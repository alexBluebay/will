<?php
class Zend_View_Helper_SetMeta extends Zend_View_Helper_Abstract 
{
    public function setMeta()
    {
        $controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        
        return $controllerName . '-' . $actionName;
       
    }
}