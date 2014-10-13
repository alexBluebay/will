<?php

class Default_Model_Components_ContactModel {
    
    public function sendMail($data)   
    {
        //library || zend mail || php mail
        
        $mail = mail($to, $subject, $message);
                                                         
        if ($mail){
            return true;
        } else {
            return false;
        }
                
    }
}
    