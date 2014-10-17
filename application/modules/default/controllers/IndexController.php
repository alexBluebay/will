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
    
    public function grabzItAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $linkModel = new Default_Model_Components_Linkuri();
        
        $message = $_GET['message'];
        $customId = $_GET['customid'];
        $id = $_GET['id'];
        $filename = $_GET['filename'];
        
        include APPLICATION_PATH  . '/../library/GrabzPicture/lib/GrabzItClient.class.php';
        
        $grabzIt = new GrabzItClient("ZWQ2MTdkNTEzOWFlNDlhNTllMTk2MDdiY2Q0MGZkMmI=",
                                     "Pz8/Kz96Pz8/PzU/P3s/NDU/P0MdPz8AV1U/Pz8/Pz8=");
        
        $result = $grabzIt->GetPicture($id);
        
        if (!$result)
        {
            return;
        }
        
        $uploadPath = APPLICATION_PATH . '/../public/default/img/uploads/';
        //Ensure that the application has the correct rights for this directory.
        file_put_contents($uploadPath . $customId.'.jpg', $result);
        
        $updateResult = $linkModel->updatePicture($customId);
        
    }


    
        public function listareSubcategoriiAction()
    {
        //: am nevoie de parametru id categorie
        // : apelez functie din model categorii care imi returneaza toate subcategoriile
        
        $parentId = $this->_request->getParam('categoryId');
        
        $subcatModel = new Default_Model_Components_Categorii();
        $subcats = $subcatModel->getSubCategorii($parentId);
        
        $this->view->subcategorii = $subcats;
    } 
    
    public function testAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $a = array( 'key' => 'ceva', 'key' => 'branza', 'key' => 'cashcaval');
        $b = array( 'foame', 'branza', 'mancare');
        
        var_dump(in_array($b, $a));
    }


    
}
   
