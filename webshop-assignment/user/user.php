<?php
    class User {
     private $userID;
     private $userName;
     private $userPhone;
     private $userAddress;
     private $userEmail;
     private $userRole;

     public function __construct($newID, $newName, $newPhone, $newAddress, $newEmail, $newRole){
         $this->userID = $newID;
         $this->userName = $newName;
         $this->userPhone = $newPhone;
         $this->userAddress = $newAddress;
         $this->userEmail = $newEmail;
         $this->userRole = $newRole;
     }
        public function getID()
        {
            return $this -> userID;
        }
        public function getName()
        {
            return $this -> userName;
        }
        public function getPhone()
        {
            return $this -> userPhone;
        }
        public function getAddress()
        {
            return $this -> userAddress;
        }
        public function getEmail()
        {
            return $this->userEmail;
        }
        public function getRole()
        {
            return $this->userRole;
        }
    }