<?php

class CaptchaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $capModel = new Default_Model_Components_CaptchaModel();
        $cap = $capModel->genCaptcha();
        
        echo $cap;
    }
}
   

