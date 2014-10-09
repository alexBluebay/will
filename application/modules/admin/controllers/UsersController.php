<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $usrModel = new Admin_Model_Components_UserModel();
        $usrList = $usrModel->listUsers();
        $this->view->userList = $usrList;
        
    }

    public function editUserAction()
    {
        $idUsr = $this->_request->getParam('id');
        $usrModel = new Admin_Model_Components_UserModel();
        $advInfo = $usrModel->editUser($idUsr);
        $form = new Admin_Form_Users();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $updResult = $usrModel->updateUser($this->_request->getParams(), $idUsr);
               
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
                   'controller' => 'users',
                   'action' => 'index'
               ), 'default'));
               
           }
       }
        
        
        $form->populate(array(
           'usrName' => $advInfo->user,
           'passwrd' => $advInfo->password
       ));
        
        
        $this->view->advInfo = $advInfo;
        $this->view->form = $form;
        
    }
    
    
    public function addUserAction()
    {
        
        $advModel = new Admin_Model_Components_UserModel();
        
        $form = new Admin_Form_Users();
        
        if($this->_request->isPost()) {
           if($form->isValid($this->_request->getParams())) {
               $usrId = $advModel->addUser($this->_request->getParams());
              
               if( isset($usrId) ) {
                    $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Utilizatorul a fost adaugata');
               
               $this->_redirect($this->view->url(array(
                   'module' => 'admin',
                   'controller' => 'users',
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
    
    public function deleteUserAction()
    {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idUsr = $this->_request->getParam('id');
        $usrModel = new Admin_Model_Components_UserModel();
        $delUser = $usrModel->delUser($idUsr);
        
            if( $delUser == '1' ) {
                 $this->_helper->getHelper('FlashMessenger')
                         ->setNamespace('success')
                         ->addMessage('Modificarea a fost efectuata');
            }
            else {
                $this->_helper->getHelper('FlashMessenger')->setNamespace('errors')->addMessage('Nimic modificat!!');
            }

        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'users',
            'action' => 'index'
        ), 'default'));

    }

}

