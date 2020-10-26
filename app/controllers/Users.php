<?php

class Users extends Controller {
  
    public function __construct(){

    $this->userModel = $this->model('User'); 

    }
    //Decide if the user is loggging in or registering and run the appropriate method
    public function index(){
      $data = [
        'title' =>'Login',
        'type' =>'none',
        'register_success' => '',
        ];
        //If its a post request decide if its a register or login request
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          //If the form type is login, run the login function
          if($_POST['type'] == 'login'){
          $this->login();
          $this->view('users\login', $data);  
        } else { //otherwise run the register function
          $this->register();
        }
      }else{ //If it isn't a post request, just load the page
        $data= ['type'=>'none'];
        $this->view('users\login', $data);
      }
    }

      //register method - validates data, adds user or throws error messages
      public function register(){
        $data =[
          'name' => trim($_POST['register-name']),
          'email' => trim($_POST['register-email']),
          'handle' => trim($_POST['register-handle']),
          'password' => trim($_POST['register-password']),
          'confirm_password' => trim($_POST['register-confirm']),
          'name_err' => '',
          'handle_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'type' =>'register',
          'register_success' => ''
        ];  
       
        //Name over 4 characters?
        if(strlen($data['name']) < 4){
          $data['name_err'] = 'Oops, user name must be 4 characters or more';
        }
        //handle has @ sign?
        if($data['handle'][0]!='@'){
          $data['handle_err'] = 'Sorry, that isn\'t a valid handle';  
        //handle unique?
        }else if($this->userModel->findUserByHandle($data['handle'])){  
          $data['handle_err'] = 'Sorry, that handle is already taken';
        }
       //email valid?
       if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $data['email_err'] = 'Sorry, that isn\'t a valid email address';
       }
       //email unique? *
       if($this->userModel->findUserByEmail($data['email'])){
        $data['name_err'] = 'Sorry, your user name or email is taken, try again.';
      }
      //* deliberately put the error in name err to disguise which fault arose
      // it also stops two copies of the message showing if both are taken

       //password over 5 characters?
        if(strlen($data['password']) < 6){
          $data['password_err'] = 'Password must be at least 6 characters and contain a number and a capital';
        }
        //Password contains a number
        if( !preg_match("#[0-9]+#", $data['password']) ) {
          $data['password_err'] =  'Password must be at least 6 characters and contain a number and a capital';
          }
        //Password must contain a capital letter
         if( !preg_match("#[A-Z]+#", $data['password']) ) {
          $data['password_err'] =  'Password must be at least 6 characters and contain a number and a capital';
          }
        //Passwords match?
        if ($data['confirm_password'] != $data['password']){
          $data['confirm_password_err'] = 'Passwords don\'t match, try again.';
        }

                //decide if the submission is error free
        if( empty($data['name_err']) && empty($data['handle_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        //run insert query from the model
            if ($this->userModel->register($data)){
              $data['register_success'] = 'Congratulations, You\'re now registered. Slide over to Log in to get started';
              echo "success";
            }else{
        //return the view with errors in the data
            $data['name'] = 'Sorry, there has been a system error, please try again later';
            echo "Sorry,  there has been a system error, please try again";
          }
        }  
          //return errors on screen
            $this->view('users\login', $data);
      }
          public function login(){
              
                // Init data
                $data =[
                  'name' => trim($_POST['login-name']),
                  'password' => trim($_POST['login-password']),
                  'email_handle_err' => '',
                  'password_err' => '', 
                  'type' =>'login',     
                ];
        
                // Validate Email
                if(empty($data['name'])){
                  $data['email_handle_err'] = 'Please enter an email or handle';
                }
                // Validate Password
                if(empty($data['password'])){
                  $data['password_err'] = 'Please enter password';
                }
                // Check for user/email
                if($this->userModel->findUserByHandle($data['name'])){
                  // User handle found
                  $inputType = "Handle";
                  
                } else if($this->userModel->findUserByEmail($data['name'])) {
                  // User email found
                  $inputType="Email";
                }else{
                  //Handle or Email not found, record error
                  $data['email_handle_err'] = 'Please check your email/handle and password';
                }
        
                // Make sure errors are empty before checking the password
                if(empty($data['email_handle_err']) && empty($data['password_err'])){
                  //If the user password is correct, return their information
                  $loggedInUser = $this->userModel->login( $inputType, $data['name'], $data['password']);
                    //If the user information was created
                    if($loggedInUser){
                    // Create Session
                    $this->createUserSession($loggedInUser);
                    //note- the user session will redirect to posts
                  } else {
                    $data['password_err'] = 'Please check your email/handle and password';
        
                    $this->view('users/login', $data);
                  }
                } else {
                  
                  $this->view('users/login', $data);
                }
            }

            public function createUserSession($user){
              $_SESSION['user_id'] = $user->id;
              $_SESSION['user_email'] = $user->email;
              $_SESSION['user_name'] = $user->name;
              $_SESSION['user_handle'] = $user->handle;
              header('location: '. URLROOT . '/posts/posts');
            }
        
            public function logout(){
              unset($_SESSION['user_id']);
              unset($_SESSION['user_email']);
              unset($_SESSION['user_name']);
              unset($_SESSION['user_handle']);
              session_destroy();
              header('location: '. URLROOT . '/users/index');
            }
            //User profile page
            public function profile($profileFlash=null){
               $data = [
              'subscriber_id' =>  $_SESSION['user_id'],
              'title' =>'profile',
              'type' =>'profile',
               ];
              //load the profile information from the model
              $profileInformation = $this->userModel->subscriberProfileById($data);

              $postStats = $this->userModel->postStats($data, 'post'); 
              $numberOfPosts = sizeof($postStats);
              $key = 'upvote_count';
              $postUpvotes= array_sum(array_column($postStats,$key));
              if($postUpvotes > 0){
              $upvotesPerPost = round(($postUpvotes / $numberOfPosts) , 2);
              }else{
                $upvotesPerPost = 0;
              }
              array_push($profileInformation, $numberOfPosts);
              array_push($profileInformation, $postUpvotes);
              array_push($profileInformation, $upvotesPerPost);
              
              $replyStats = $this->userModel->postStats($data, 'reply'); 
              $numberOfReplies = sizeof($replyStats);
              $replyUpvotes= array_sum(array_column($replyStats,$key));
              if($replyUpvotes > 0){
                
              $upvotesPerReply = round(($replyUpvotes / $numberOfReplies) , 2);
              }else{
                $upvotesPerReply = 0;
              }
            
              
              array_push($profileInformation, $numberOfReplies);
              array_push($profileInformation, $replyUpvotes);
              array_push($profileInformation, $upvotesPerReply);
              

              //load the page, passing in the profile information
              if(isset($profileFlash)){
              $this->viewProfile('users\profile', $data, $profileInformation, $profileFlash);
          }else{
            $this->viewProfile('users\profile', $data, $profileInformation);
          }
        }
        //upload profile photo from profile page
        public function uploadPhoto(){
          $data = [
            'subscriber_id' =>  $_SESSION['user_id'],
            'title' =>'profile',
            'type' =>'uploadPhoto',
             ];
          
          if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          //If the form type is photo upload, run the login function
            if($_POST['type']==='photo-upload'){
              //add the file and record it in the database
              //$status returns true if successful or with an error message
            $status = $this->userModel->uploadProfilePhoto($data);
              //If upload was successful, pass through a success message
              if ($status===true){
                $profileFlash = ['success'=>"Photo Uploaded"];
                $this->profile($profileFlash);
              }else{
                //if upload was not successful, pass through the error message in $status
                $profileFlash = ['error'=>$status];
                $this->profile($profileFlash);
             }
          }
            
        }
      }
    
    }//end of class
    