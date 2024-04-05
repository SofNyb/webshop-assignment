<?php
    class User {
     private $userID;
     private $userName;
     private $userEmail;
     private $userRole;

     public function __construct($newID, $newName, $newEmail, $newRole){
         $this->userID = $newID;
         $this->userName = $newName;
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
        public function getEmail()
        {
            return $this->userEmail;
        }
        public function getRole()
        {
            return $this->userRole;
        }
    }