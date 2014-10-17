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
                        
                
        $nrLinks = $listModel->getCountLinks($subcategoryId);
        
        //
        $maxPePag = 16;
        $currPage = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
        
        $nrPagini = ceil($nrLinks/$maxPePag);
       
        $offsetStart = ($currPage-1) * $maxPePag;
        
        $this->view->currPage = $currPage;
        $this->view->nrPagini = $nrPagini;
        $this->view->maxPePag = $maxPePag;
        

        
        $listare = $listModel->getLinkuri($subcategoryId, array(
            'offsetStart' => $offsetStart,
            'maxPePag' => $maxPePag,
        ));
              

        
       
        //exit;
        
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
                
                $formValues = $form->getValues();
                
                if ($formValues['linkType'] == '1') {
                    $isBackLink = $linkModel->checkLinkExchange($formValues['url']);
                } else {
                    $isBackLink = false;
                }
                
                if ($isBackLink === TRUE){
                    
                    $lastLink = $linkModel->insertLink($formValues);

                    $this->_redirect($this->view->url(array(
                            'linkId' => $lastLink,
                            'title' => 'temp'
                        ), 'detalii_link'));
                    }
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
   

