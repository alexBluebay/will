<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $authModel = new Admin_Model_Components_AuthModel();
        $authModel->logged();
        $form = new Admin_Form_loginForm();
        
        if(isset($_POST['sendData'])){
            
            $data = $this->_request->getParams();
            
            $response = $authModel->login($data);
            
            if ($response){
                $this->_redirect($this->view->url(array(
                    'module' => 'admin',
                    'controller' => 'dashboard',
                    'action' => 'index'
                ), 'default'));
            } else {
                
                $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('errors')
                            ->addMessage('Numele de utilizator sau parola incorecte!');
                
                $this->_redirect($this->view->url(array(
                    'module' => 'admin',
                    'controller' => 'index',
                    'action' => 'index'
                ), 'default'));
                
            }
        }
        
        
        $this->view->form = $form;
    }
    
    public function logoutAction(){
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        session_destroy();
        $this->_redirect($this->view->url(array(
            'module' => 'admin',
            'controller' => 'index',
            'action' => 'index'
        ), 'default'));
    }


}

