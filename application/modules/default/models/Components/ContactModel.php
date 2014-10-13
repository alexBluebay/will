<?php

class Default_Model_Components_ContactModel {
    
    public function sendMail($data)   
    {
        $settingsDbTable = new Default_Model_DbTable_Settings();
        
        $select = $settingsDbTable->select()
                ->from('settings')
                ->where("param = 'emailAdmin'");
        $res = $settingsDbTable->fetchRow($select);
        
        //library || zend mail || php mail
        
        $message = $data['message'].'
                Telefon: '.$data['phone'];
        
        $mailObj = new Zend_Mail();
        $mailObj->addTo($res->val);
        $mailObj->setFrom($data['email'], $data['name']);
        $mailObj->setSubject('Admin, ai un mesaj nou de pe will.ro');
        $mailObj->setBodyText($message);
        $mailObj->send();
        
                                                         
        if ($mail){
            return true;
        } else {
            return false;
        }
                
    }
}
    