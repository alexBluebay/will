<?php

class Admin_CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $catModel = new Admin_Model_Components_CategoryModel();
        $catList = $catModel->getCategoriesAll();
        $this->view->catL = $catList;
        
    }

    public function editCategoryAction()
    {
        $idCat = $this->_request->getParam('id');
        $catModel = new Admin_Model_Components_CategoryModel();
        $catInfo = $catModel->editCategory($idCat);
        $form = new Admin_Form_Categories();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $updResult = $catModel->updateCategory($this->_request->getParams(), $idCat);
               
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
                   'controller' => 'category',
                   'action' => 'index'
               ), 'default'));
               
           }
       }
        
        
        $form->populate(array(
           'category' => $catInfo->parentId,
           'CatName' => $catInfo->category,
           'description' => $catInfo->description           
       ));
        
        
        $this->view->catInfo = $catInfo;
        $this->view->form = $form;
        
    }
    
    
    public function addCategoryAction()
    {
        
        $catModel = new Admin_Model_Components_CategoryModel();
        
        $form = new Admin_Form_Categories();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $catId = $catModel->addCategory($this->_request->getParams());
               echo $catId;
               if( isset($catId) ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'category',
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
    
    public function delCategoryAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idCat = $this->_request->getParam('id');
        $catModel = new Admin_Model_Components_CategoryModel();
        
        try {
            $delRes = $catModel->delCategory($idCat);
            
            $this->_helper->getHelper('FlashMessenger')
                 ->setNamespace('success')
                 ->addMessage('Modificarea a fost efectuata');
        }
        catch(Exception $e) {
            $this->_helper->getHelper('FlashMessenger')
                    ->setNamespace('errors')
                    ->addMessage($e->getMessage());
        }
        
        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'category',
            'action' => 'index'
        ), 'default'));

    }

}

