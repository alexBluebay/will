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
        $form = new Default_Form_ContactForm();
        
        
        if($this->_request->isPost()){
            if ($form->isValid($this->_request->getParams())){
                
                $contactModel = new Default_Model_Components_ContactModel();
                
                $res = $contactModel->sendMail( $form->getValues() );
                
                if ($res) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Mesajul a fost trimis cu succes!');
                } else {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('errors')
                            ->addMessage('Mesajul nu a fost trimis, va rugam incercati inca o data');
                }
                
                $this->_redirect($this->view->url(array(
							'module' => 'default',
							'controller' => 'pagini',
							'action' => 'contact'
					)));
            }
            
        }
        
        
        $this->view->pagini = $contact;
        $this->view->form = $form;
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
   

