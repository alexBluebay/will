<?php

class Admin_ModulesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $modModel = new Admin_Model_Components_ModulesModel();
        
        if(isset($_POST['action']) && $_POST['action'] == 'meteo'){
            
            $updMeteo = $modModel->editMeteo($_POST['meteo']);
            $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
            
            $this->_redirect($this->view->url(array(
                'module' => 'admin',
                'controller' => 'modules',
                'action' => 'index'
            ), 'default'));
            exit;
        }
        
        if(isset($_POST['action']) && $_POST['action'] == 'exchange'){
            $updCurr = $modModel->editCurr($_POST['currs']);
            $this->_helper->getHelper('FlashMessenger')
                            ->setNamespace('success')
                            ->addMessage('Modificarea a fost efectuata');
            
            $this->_redirect($this->view->url(array(
                'module' => 'admin',
                'controller' => 'modules',
                'action' => 'index'
            ), 'default'));
            exit;
        }
        
        $currList = $modModel->exchangeModuleList();
        $meteoList = $modModel->meteoModuleList();
        
        $this->view->currList = $currList;
        $this->view->meteo = $meteoList;
        
    }
    
    public function sortCurrencyAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        // validari
        if( !isset($_POST['sortedCurrencyIds']) 
                || !is_array($sortedCurrencyIds = $this->_request->getPost('sortedCurrencyIds'))) {            
            exit;
        }
        
        // update pozitii
        $modModel = new Admin_Model_Components_ModulesModel();
        $done = $modModel->updateCurrencyPosition($sortedCurrencyIds);
        
    }
    
    public function sortMeteoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        // validari
        if( !isset($_POST['sortedMeteoIds']) 
                || !is_array($sortedMeteoIds = $this->_request->getPost('sortedMeteoIds'))) {            
            exit;
        }
        
        // update pozitii
        $modModel = new Admin_Model_Components_ModulesModel();
        $done = $modModel->updateMeteoPosition($sortedMeteoIds);
        
    }
    
    
    
    public function cronExchangeAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modModel = new Admin_Model_Components_ModulesModel();
        
        $activeCurrs = $modModel->cronExchangeList();
        
        
    }
    
    public function cronMeteoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modModel = new Admin_Model_Components_ModulesModel();
        
        $meteoArr = $modModel->cronMeteoModel();
        
    }

}

