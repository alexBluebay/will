<?php

class LinkuriController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function listareLinkuriAction()
    {
        // ai nevoie de parametru subcategorie        
        $subcategoryId = $this->_request->getParam('subcategoryId');

        // apelezi functie getLinkuri cu parametru     
        $listModel = new Default_Model_Components_Linkuri();
        $catModel = new Default_Model_Components_Categorii();
        
        
        $category = $catModel->getCategory($subcategoryId); 
        
        $listare = $listModel->getLinkuri($subcategoryId);
              
        
        
        //echo urlencode('<script>alert("a")</script>'); exit;
        $this->view->linkuri = $listare;
        $this->view->category = $category;

    }
    public function detaliiLinkAction()
    {
        // ai nevoie de parametru subcategorie
        
        $linkId = $this->_request->getParam('linkId');
        // apelezi functie getLinkuri cu parametru
        
        
        $linkModel = new Default_Model_Components_Linkuri();
        $link = $linkModel->getDetaliuLink($linkId);
        $subcategorieId = $link->categoryId;
        $linkuri =$linkModel->getExtraLinkuri($subcategorieId, $linkId);
        
        $this->view->link = $link;
        $this->view->linkuri = $linkuri;
    }
    
    public function adaugaLinkAction()
    {
        
        $form = new Default_Form_AddLink();
        
        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getParams())) {
                $linkModel = new Default_Model_Components_Linkuri();
                
                $lastLink = $linkModel->insertLink($form->getValues());
                
            }
            
        
        }
        
        $this->view->form = $form;
        
    }
    
    public function sponsorLinkAction()
    {
        
        
        $sponsorModel = new Default_Model_Components_Sponsor();
        $id = $this->_request->getParam('id');
        $sponsor = $sponsorModel->getSponsorLink($id);
        $sponsorInfo = $sponsorModel->getSponsorInfo($id);
        
        $this->view->sponsor = $sponsor;
        $this->view->info = $sponsorInfo;
        
    }
    
    public function linkuriUtileAction()
    {
        $utileModel = new Default_Model_Components_Linkuri();
        $utile = $utileModel->getLinkuriUtile();
        
        $this->view->utile = $utile;
    }
    
  



    
}
   

