<?php
class Zend_View_Helper_GetParams extends Zend_View_Helper_Abstract 
{
    public function GetParams()
    {
        $controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        
        
        return array(
            'controllerName' => $controllerName,
            'actionName' => $actionName
        );
        
    }
}