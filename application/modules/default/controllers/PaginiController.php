<?php

class PaginiController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function avantajeAction()
    {
        $avantajeModel = new Default_Model_Components_Pagini();
        $avantaje = $avantajeModel->getPagini();
        
        $this->view->pagini = $avantaje;
    }
    
    public function contactAction()
    {
        $contactModel = new Default_Model_Components_Pagini();
        $contact = $contactModel->getPagini();
        
        $this->view->pagini = $contact;
    }
    
    public function serviciiAction()
    {
        $serviciiModel = new Default_Model_Components_Pagini();
        $servicii = $serviciiModel->getPagini();
        
        $this->view->pagini = $servicii;
    }
     
    public function termeniAction()
    {
        $termeniModel = new Default_Model_Components_Pagini();
        $termeni = $termeniModel->getPagini();
        
        $this->view->pagini = $termeni;
    }





    
}
   

