<?php

class Admin_PromoLinksController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $plModel = new Admin_Model_Components_PromoLinkModel();
        $promoList = $plModel->listPromoLinks();
        $this->view->promoL = $promoList;
        
    }
    
    public function sortLinksAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        // validari
        if( !isset($_POST['sortedLinksIds']) 
                || !is_array($sortedLinksIds = $this->_request->getPost('sortedLinksIds'))) {            
            exit;
        }
        
        // update pozitii
        $promoLinksModel = new Admin_Model_Components_PromoLinkModel();
        $done = $promoLinksModel->updatePromoPosition($sortedLinksIds);
        
    }

    public function editLinkAction()
    {
        $idLink = $this->_request->getParam('id');
        
        $promoLinksModel = new Admin_Model_Components_PromoLinkModel();
        
        $linkInfo = $promoLinksModel->editPromoLink($idLink);
        
        $form = new Admin_Form_PromoLinksForm(array(
            'a' => 'edit'
        ));

        if($this->_request->isPost()) {
            
           if($form->isValid($this->_request->getParams())) {
               $updResult = $promoLinksModel->updatePromoLink($this->_request->getParams(), $idLink);
               
               if( $updResult ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
               } else {
                   //$this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
               }
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'promo-links',
                   'action' => 'index'
               ), 'default'));
               
           }
       }
        
        
        $form->populate(array(
           'layout' => $linkInfo->link_layout,
           'title' => $linkInfo->title,
           'url' => $linkInfo->url,
           'desc' => $linkInfo->desc           
       ));
        
        
        $this->view->linkInfo = $linkInfo;
        $this->view->form = $form;
        
    }
    
    
    public function addLinkAction()
    {
        
        $promoLinksModel = new Admin_Model_Components_PromoLinkModel();
        
        $form = new Admin_Form_PromoLinksForm();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $linkId = $promoLinksModel->addPromoLink($this->_request->getParams());
              
               if( isset($linkId) ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Linkul a fost adaugat');
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'promo-links',
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
    
    public function deleteLinkAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idLink = $this->_request->getParam('id');
        $promoLinksModel = new Admin_Model_Components_PromoLinkModel();
        $delLink = $promoLinksModel->delPromoLink($idLink);
        
            if( $delLink == '1' ) {
                 $this->_helper->getHelper('FlashMessenger')
                         ->setNamespace('success')
                         ->addMessage('Linkul sponsorizat a fost sters');
            } else {
                $this->_helper->getHelper('FlashMessenger')
                        ->setNamespace('errors')
                        ->addMessage('Linkul nu exista!');
            }

        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'promo-links',
            'action' => 'index'
        ), 'default'));

    }

}

