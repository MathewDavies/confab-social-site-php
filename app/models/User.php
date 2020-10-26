<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Register user
    public function register($data){
        $this->db->query('INSERT INTO subscriber (name, email, handle, password) VALUES(:name, :email, :handle, :password)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':handle', $data['handle']);
        $this->db->bind(':password', $data['password']);    
      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
//Put these into one function??
    public function findUserByName($name){
        $this->db->query('SELECT * FROM subscriber WHERE name = :user_name');
        // Bind value
        $this->db->bind(':user_name', $name);
  
        $row = $this->db->single();
  
        // Check row
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
      }
      public function findUserByEmail($email){
        $this->db->query('SELECT * FROM subscriber WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);
  
        $row = $this->db->single();
  
        // Check row
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
      }

      public function findUserByHandle($handle){
        $this->db->query('SELECT * FROM subscriber WHERE handle = :handle');
        // Bind value
        $this->db->bind(':handle', $handle);
  
        $row = $this->db->single();
  
        // Check row
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
      }
      public function subscriberProfileById($data){
        $this->db->query('SELECT * FROM subscriber WHERE id = :subscriber_id');
        // Bind value
        $this->db->bind(':subscriber_id', $data['subscriber_id']);
  
        $row = $this->db->resultSetAssoc();
  
        // Check row
        if($this->db->rowCount() > 0){
          return $row;
        } else {
          return false;
        }
      }
      // Login User
    public function login($inputType, $name, $password){

    if($inputType==="Handle"){
      $this->db->query('SELECT * FROM subscriber WHERE handle = :name');
      $this->db->bind(':name', $name);
    }else {
      $this->db->query('SELECT * FROM subscriber WHERE email = :name');
      $this->db->bind(':name', $name);
    }
      $row = $this->db->single();

      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    
    Public function postStats($data, $type){
      $this->db->query('SELECT upvote_count FROM '.  $type .  ' WHERE subscriber_id = :subscriber');
      $this->db->bind(':subscriber', $data['subscriber_id']);
      return $this->db->resultSetAssoc();
    }

    Public function uploadProfilePhoto($data){
      if(isset($_POST['photo-submit'])){
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');
        if(in_array($fileActualExt, $allowed)){
          //if there is no upload error
          if($fileError===0){
            // if file is less than 2mb
            if($fileSize < 2000000){
              //create a unique file name for the file
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = BASEROOT.'/public/uploads/'. $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            //need to pass it back to the screen after refresh

             //query to find out the path of the original image
             $this->db->query('Select photo_name From subscriber WHERE id = :subscriber_id') ;
             $this->db->bind(':subscriber_id', $data['subscriber_id']);
             $previousFile = $this->db->singleArray();

            //query to update the new file name to the database   
             $this->db->query('UPDATE subscriber SET photo_name =  :photo_name WHERE id = :subscriber_id') ;
             $this->db->bind(':subscriber_id', $data['subscriber_id']);
             $this->db->bind(':photo_name', $fileNameNew);
             // Check row and return a status
             if($this->db->execute()){
            $previousFileString = $previousFile['photo_name'];
            $previousFilePath = BASEROOT.'/public/uploads/'. $previousFileString; 
           //if the previous file isn't the default image and it exists, delete it
              if($previousFile !="anonymousprofile.jpg"){
                if (file_exists($previousFilePath)) {
                  unlink($previousFilePath);
               }
             }
             return true;
            } else {
              return "Upload error, please try a different file";
            }
            }else{
              return "please have a file below 2MB";
            }
          }else{
           return "upload failed, try again";
          }
        }else{
          return "you cannot upload files of this type";
        }
      }
    }

    


}
