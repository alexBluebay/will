<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //modificare
        $linkModel = new Default_Model_Components_Linkuri();
        
        $lastLinks = $linkModel->getLastLinkuri();
        $promoLinks = $linkModel->getPromoLinkuri();
        //print_r($lastLinks); exit;
       // model categorii
        
       // model link-uri
        
       // model pagini
        
       // homepage: apelez functie din model linkuri care imi returneaza ultimele linkuri adaugate
        
        $this->view->lastLinks = $lastLinks;
        $this->view->promoLinks = $promoLinks;
        
    }



    
}
   

