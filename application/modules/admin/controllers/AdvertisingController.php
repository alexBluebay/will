<?php

class Admin_AdvertisingController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $advModel = new Admin_Model_Components_AdvertisingModel();
        $advList = $advModel->listAdvertising();
        $this->view->advL = $advList;
        
    }

    public function editAdvertisingAction()
    {
        $idAdv = $this->_request->getParam('id');
        $advModel = new Admin_Model_Components_AdvertisingModel();
        $advInfo = $advModel->editAdvertisings($idAdv);
        $form = new Admin_Form_Advertising();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $updResult = $advModel->updateAdvertising($this->_request->getParams(), $idAdv);
               
               if( $updResult ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
               }
               else {
                   //$this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
               }
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'advertising',
                   'action' => 'index'
               ), 'default'));
               
           }
       }
        
        
        $form->populate(array(
           'layoutType' => $advInfo->layout,
           'title' => $advInfo->title,
           'advCode' => $advInfo->adv_code           
       ));
        
        
        $this->view->advInfo = $advInfo;
        $this->view->form = $form;
        
    }
    
    
    public function addAdvertisingAction()
    {
        
        $advModel = new Admin_Model_Components_AdvertisingModel();
        
        $form = new Admin_Form_Advertising();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $linkId = $advModel->addAdvertising($this->_request->getParams());
              
               if( isset($linkId) ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Reclama a fost adaugata');
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'advertising',
                   'action' => 'index'
               ), 'default'));
               
               }
               else {
                   //$this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
               }
               
           }
       }        
        
        $this->view->form = $form;
        
    }
    
    public function delAdvertisingAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idAdv = $this->_request->getParam('id');
        $advModel = new Admin_Model_Components_AdvertisingModel();
        $delAdvertising = $advModel->delAdvertising($idAdv);
        
            if( $delAdvertising == '1' ) {
                 $this->_helper->getHelper('FlashMessenger')
                         ->setNamespace('success')
                         ->addMessage('Modificarea a fost efectuata');
            }
            else {
                $this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
            }

        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'advertising',
            'action' => 'index'
        ), 'default'));

    }

}

