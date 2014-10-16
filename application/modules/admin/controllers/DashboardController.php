<?php

class Admin_DashboardController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $linksModel = new Admin_Model_Components_Links();
        $linkList = $linksModel->listLinks();
        $this->view->listObj = $linkList;
        
       
    }
    
    public function editLinkAction()
    {   
        $linkId = $this->_request->getParam('linkId');
        $linkModel = new Admin_Model_Components_Links();
        $linkInfo = $linkModel->infoLinks($linkId);
        $form  = new Admin_Form_Links();
        
        $form->populate(array(
           'category' => $linkInfo->categoryId,
           'url' => $linkInfo->url,
           'title' => $linkInfo->title,
           'email' => $linkInfo->email,
           'short' => $linkInfo->shortDescription,
           'long' => $linkInfo->longDescription,
           'status' => $linkInfo->status,
           'type' => $linkInfo->type,
           
       ));
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $updResult = $linkModel->updateLink($this->_request->getParams(), $linkId);
               
               if( $updResult ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
               }
               else {
                   //$this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
               }
               
               $this->_redirect($this->view->url(array(
                   'linkId' => $linkId
               ), 'viewLink'));
               
           }
       }
       
        
        
        $this->view->form = $form;
        $this->view->linkInfo = $linkInfo;
    }
    
    public function viewLinkAction(){
        
        $linkId = $this->_request->getParam('linkId');
        
        $linkInfoModel = new Admin_Model_Components_Links();
        
        $linkInfo = $linkInfoModel->infoLinks($linkId);
        $catName = $linkInfoModel->getCategoryName($linkInfo->categoryId);
        
        $this->view->linkInfo = $linkInfo;
        $this->view->catName = $catName->category;
                
    }
    
    public function allLinksAction()
    {
        $linksModel = new Admin_Model_Components_Links();
        $searchForm = new Admin_Form_SearchForm();
        $nrLinks = $linksModel->countListAllLinks();
        
        $maxPePag = 16;
        $currPage = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
        
        $nrPagini = ceil($nrLinks/$maxPePag);
       
        $offsetStart = ($currPage-1) * $maxPePag;
        
        $this->view->currPage = $currPage;
        $this->view->nrPagini = $nrPagini;
        $this->view->maxPePag = $maxPePag;
        $this->view->totalLinks = $nrLinks;
        $this->view->form = $searchForm;
          
        $linkList = $linksModel->listAllLinks(array(
            'offsetStart' => $offsetStart,
            'maxPePag' => $maxPePag
        ), $this->_request->getParams());
        
        $this->view->listObj = $linkList;
    }
    
    public function delLinkAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $linkId = $this->_request->getParam('linkId');
        $linksModel = new Admin_Model_Components_Links();
        $linkDeleted = $linksModel->delLink($linkId);
        
            if( $linkDeleted == '1' ) {
                 $this->_helper->getHelper('FlashMessenger')
                         ->setNamespace('success')
                         ->addMessage('Linkul a fost sters');
            }
            else {
                $this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Linkul nu a fost gasit!');
            }

        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'dashboard',
            'action' => 'all-links'
        ), 'allLinks'));

    }


}

