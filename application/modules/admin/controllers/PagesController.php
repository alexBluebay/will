<?php

class Admin_PagesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $pageModel = new Admin_Model_Components_PagesModel();
        $pageList = $pageModel->listPages();
        $this->view->pagesList = $pageList;
        
    }

    public function editPageAction()
    {
        $idPage = $this->_request->getParam('id');
        $pageModel = new Admin_Model_Components_PagesModel();
        $pageInfo = $pageModel->editPages($idPage);
        $form = new Admin_Form_Pages();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $updResult = $pageModel->updatePages($this->_request->getParams(), $idPage);
               
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
                   'controller' => 'pages',
                   'action' => 'index'
               ), 'default'));
               
           }
       }
        
        
        $form->populate(array(
           'type' => $pageInfo->pageType,
           'metaTitle' => $pageInfo->metaTitle,
           'metaKeys' => $pageInfo->metaKeywords,
           'descriptionMeta' => $pageInfo->metaDescription,
           'pageContent' => $pageInfo->content
       ));
        
        
        $this->view->pageInfo = $pageInfo;
        $this->view->form = $form;
        
    }
    
    
    public function addPagesAction()
    {
        
        $pageModel = new Admin_Model_Components_PagesModel();
        
        $form = new Admin_Form_Pages();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $linkId = $pageModel->addPages($this->_request->getParams());
              
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

}

