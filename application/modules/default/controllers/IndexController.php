<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       //mod
        $linkModel = new Default_Model_Components_Linkuri();
        
        $lastLinks = $linkModel->getLastLinkuri();
        $promoLinks = $linkModel->getPromoLinkuri();
        
        $this->view->lastLinks = $lastLinks;
        $this->view->promoLinks = $promoLinks;
        
    }



    
}
   
