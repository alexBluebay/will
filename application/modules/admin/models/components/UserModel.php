<?php

class Admin_Model_Components_UserModel
{
   /**
    * 
    * @return array/object with the list of links
    */
    public function listUsers()   
    {
        $dbTableAdv = new Admin_Model_DbTable_AdminUsers();
        
        $select = $dbTableAdv->select()
                ->from(array('u' => 'admin_users'), array('*'))
                ->order('id DESC');
        
        $listThem = $dbTableAdv->fetchAll($select);
        
        return $listThem;
    }
    
    public function editUser($idAdv){
        $dbTableAdv = new Admin_Model_DbTable_AdminUsers();
        
        $select = $dbTableAdv->select()
                ->from(array('u' => 'admin_users'), array('*'))
                ->where('u.id = ?', $idAdv);
        $listCat = $dbTableAdv->fetchRow($select);
        
        return $listCat;
    }
    
    
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
    
    public function updateUser($data, $idUsr){                  
        $hash = crypt($data['passwrd'], $this->generateBlowfishSalt());

        //
       //$hash2 = crypt($data['passwrd'], $hash);  // validate login 
       // var_dump($hash2 == $hash);     // validate login   
       //exit;

        $dbTableAdv = new Admin_Model_DbTable_AdminUsers();
        $updLink = $dbTableAdv->update(array(
            'user' => $data['usrName'],
            'password' => $hash
        ), "id = '$idUsr'");

        return $idUsr;
        
    }
    
    public function addUser($data){
        $dbTableUsr = new Admin_Model_DbTable_AdminUsers();
        $hash = crypt($data['passwrd'], $this->generateBlowfishSalt());
        $usrId = $dbTableUsr->insert(array(
            'user' => $data['usrName'],
            'password' => $hash
        ));
        
        return $usrId;
    }
    
    public function delUser($id){
        $dbTableUsr = new Admin_Model_DbTable_AdminUsers();

        $res = $dbTableUsr->delete(array(
            'id = ?' => $id
        ));
        
        return $res;
    }
    
}