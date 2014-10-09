<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       //mod
        $linkModel = new Default_Model_Components_Linkuri();
        
        $lastLinks = $linkModel->getLastLinkuri();
        $promoLinks = $linkModel->getPromoLinkuri();
        
        $this->view->lastLinks = $lastLinks;
        $this->view->promoLinks = $promoLinks;
        
    }
    
    public function grabzItAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $message = $_GET["message"];
        $customId = $_GET["customid"];
        $id = $_GET["id"];
        $filename = $_GET["filename"];
         
        //Custom id can be used to store user ids or whatever is needed for the later processing of the
        //resulting screenshot
        
        require APPLICATION_PATH . '/../library/GrabzPicture/lib/GrabzItClient.class.php';
        
        $grabzIt = new GrabzItClient("ZWQ2MTdkNTEzOWFlNDlhNTllMTk2MDdiY2Q0MGZkMmI=",
                                     "Pz8/Kz96Pz8/PzU/P3s/NDU/P0MdPz8AV1U/Pz8/Pz8=");
        
        $result = $grabzIt->GetPicture($id);
         
        if (!$result)
        {
            return;
        }
         
        //Ensure that the application has the correct rights for this directory.
        file_put_contents("images" . DIRECTORY_SEPARATOR . $filename, $result);
    }




    
}
   
