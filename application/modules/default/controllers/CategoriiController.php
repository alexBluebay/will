<?php

class CategoriiController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function listareCategoriiAction()
    {
        // : apelez functie din model categorii care imi returneaza toate categoriile
        // pentru fiecare categorie se listeaza subcategoriile aferente 
       
        
        $catModel = new Default_Model_Components_Categorii();
        $cats = $catModel->getCategoriiExtra();
        $this->view->categorii = $cats;
    
    }
    
    public function listareSubcategoriiAction()
    {
        //: am nevoie de parametru id categorie
        // : apelez functie din model categorii care imi returneaza toate subcategoriile
        
        $parentId = $this->_request->getParam('categoryId');
        $category = $this->_request->getParam('category');
        
        
        $subcatModel = new Default_Model_Components_Categorii();
        $subcats = $subcatModel->getSubCategorii($parentId);
        
        $this->view->subcategorii = $subcats;
        $this->view->currCategory = $category;
    } 
    
}
   