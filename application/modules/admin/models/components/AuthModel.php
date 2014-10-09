<?php

class Admin_Model_Components_AuthModel
{
    protected function generateBlowfishSalt()
    {
        $salt = "";
        $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 22; $i++) {
          $salt .= $salt_chars[array_rand($salt_chars)];


        }            
        $salt = sprintf('$2a$%02d$', 9) . $salt;
        
        return $salt;
    }
    
    public function login($data){
        
        $userTable = new Admin_Model_DbTable_AdminUsers();
        
        $select = $userTable->select()
                    ->from(array('u' => 'admin_users'), array('*'))
                    ->where('user = ?', $data['usrName']);
        
        $usrObj = $userTable->fetchRow($select);
        
        if ($usrObj){
            
            $hash = crypt($data['passwrd'], $this->generateBlowfishSalt());
            $hash2 = crypt($data['passwrd'], $usrObj->password);

            if ($hash2 == $usrObj->password){                      

                $_SESSION['admin']['logged_in'] = true;
                $_SESSION['admin']['ip'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['admin']['user'] = $usrObj->user;
                return true;
            } else {
                return false;
            } 
        }
        return false;
        
    }
    
    public function logged (){    
        if (!isset($_SESSION['admin']['logged_in']) || $_SESSION['admin']['logged_in'] == false) {
            
            $_SESSION['admin']['ip'] = $_SERVER['REMOTE_ADDR'];
            
            return false;
            
        } else {
            
            if ($_SESSION['admin']['ip'] !== $_SERVER['REMOTE_ADDR']) {
                
                session_destroy();
                $_SESSION['admin'] = array();
                
                return false;
            }
        }
        
        return true;
    }
    
}