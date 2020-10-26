<?php

class Posts extends controller{

    public function __construct(){
        $this->userModel = $this->model('Post'); 

    }
    private function generateLikes($user, $feed){
        //function takes in user ID and generates a list of posts they upvoted
        //It also takes in the feed data and adds a yes or no to a column to show if they currently liked it
       
        if($user['type']==="postfeed"){
        //generate a table of posts the user has upvoted
        $likedTable = $this->userModel->upvotesByUser($user['user']);
        }else {
            $likedTable = $this->userModel->upvotesRepliesByUser($user['user']);
        }
       //produce an array from the table with a list of liked posts
        $liked = [];
        for ($k=0; $k < count($likedTable); $k++){
            if($user['type']==="postfeed"){
            $l = $likedTable[$k]['post_id'];
            }else{
            $l = $likedTable[$k]['reply_id'];
            }
            array_push($liked, $l);   
        }
        //take the general feed and append a liked field and yes or no
        for ( $i = 0; $i < count($feed); $i++ ){

            $j = ($feed[$i]['id']);
                if(in_array ($j, $liked)){
                    $feed[$i]["upvoted"] = "yes";
                 }else{
                    $feed[$i]["upvoted"] = "no";
                 }
            }
            return $feed;
        }

      
    //Option to pass in flash messages if the page is being reloaded with $flash
    public function index($postFlash=NULL){
    
    //If the user is logged in
    if(isLoggedIn()){
        $data1 = [
        'user'=>$_SESSION['user_id'],   
        'type' =>'postfeed',
   ];
       //generate data for the the feed 
       $feed = $this->userModel->PostsByAll();
       //Add whether the user has upvoted the post or not
       $feedData = $this->generateLikes($data1, $feed);
       //check for flash messages 
          if(isset($postFlash)){
       //pass in data with $flash variable
            $this->viewFeed('posts/posts', $data1['user'], $feedData, $postFlash);
          }else{   
       //pass in data without $flash variable
           $this->viewFeed('posts/posts', $data1['user'], $feedData);
        }    
       //if not logged in, redirect to the login page
        } else{
            $this->view('users/index');  
        }
    }

    public function addPostUpvote(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
            'update_type'=>"post",    
            'subscriber_id' => trim($_POST['subscriber_id']),
            'post_id' => trim($_POST['post_id'])
            ];
            $this->userModel->addPostUpvote($data);
        }
    }
    public function removePostUpvote(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'update_type'=>"post",
                    'subscriber_id' => trim($_POST['subscriber_id']),
                    'post_id' => trim($_POST['post_id'])
                    ];
                $this->userModel->removePostUpvote($data);
            }
        }
        public function addReplyUpvote(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
            'update_type'=>"reply",    
            'subscriber_id' => trim($_POST['subscriber_id']),
            'post_id' => trim($_POST['post_id'])
            ];
            $this->userModel->addPostUpvote($data);
        }
    }
    public function removeReplyUpvote(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = [
        'update_type'=>"reply",    
        'subscriber_id' => trim($_POST['subscriber_id']),
        'post_id' => trim($_POST['post_id'])
        ];
        $this->userModel->removePostUpvote($data);
    }
}



     public function addPost(){
        if(isLoggedIn()){
            $data = [
                'title' =>'Welcome',
           ];
           $subscriber =   $_SESSION['user_id'];
           //if there is content in the type field
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
               //if there is a body insert the data
               if($_POST['add-post-body'] != null){

                    $data =[
                        'body' => trim($_POST['add-post-body']),
                        'subscriber' => $_SESSION['user_id'],
                        'upvote_count' => 0,
                        'error' => ''
                    ];
                    //add the post to database  
                    $this->userModel->addPost($data);
                    //create a flash message variable
                        $postFlash['message'] = "Post added";
                    //rerun the index page with the optional flash variable    
                        $this->index($postFlash);
                // if there isn't sufficient information
                }else{
                    //rerun the index page with the optional flash variable
                    $postFlash['error'] = "Your post body is empty.";
                    $this->index($postFlash);
                }
            //if it isn't a post request, just show the page
           } else{
            $this->index();
        // if the user isn't logged in, divert him to the login page
        }
        }else{
            $this->view('users/index');   
        }
     }//close addpost

     public function postDetail ($postId=null, $replyFlash=null){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){   
                $post = $_POST['post_id'];
            }    
            $data0 = [
                'user'=>$_SESSION['user_id'],   
                'type' =>'replyfeed',
           ];
            //query the model for the post information
            $data1 = $this->userModel->postByPostId($post);
            //query the model for the reply information
            $feed = $this->userModel->repliesByPostId($post);
            
            $data2 = $this->generateLikes($data0, $feed);
            
            //open the view and send these through to it to be created
            $this->viewFeed('posts/postdetail', $data1, $data2); 
            }
    
    public function addReply(){
        if(isLoggedIn()){
            $data = [
                'title' =>'Welcome',
           ];
           $subscriber =   $_SESSION['user_id'];
           //if there is content in the type field
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
               //if there is a body insert the data
               if($_POST['add-reply-body'] != null){
                    $postId = $_POST['post_id'];
                    $data =[
                        'body' => trim($_POST['add-reply-body']),
                        'subscriber' => $_SESSION['user_id'],
                        'upvote_count' => 0,
                        'error' => '',
                        'post_id'=>$_POST['post_id']  

                    ];
                    //add the post to database  
                    $this->userModel->addReply($data);
                    //create a flash message variable
                        $replyFlash['message'] = "Reply added";
                    //rerun the postDetail page with the optional flash variable    
                        $this->postDetail($postId, $replyFlash);
                // if there isn't sufficient information
                }else{
                    //rerun the index page with the optional flash variable
                    $replyFlash['error'] = "Your post body is empty.";
                    $this->postDetail($postId, $replyFlash);
                }
            //if it isn't a post request, just show the page
           } else{
            $this->postDetail($postId);
        // if the user isn't logged in, divert him to the login page
        }
        }else{
            $this->view('users/index');   
        }
     }//close addpost     



    // public function deletePost(){
    //     if(isLoggedIn()){
    //         if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    //             $data = [
    //             'post' => trim($_GET['post']),
    //             ];
    //             //run the delete function
    //             $this->userModel->deletePost($data);
    //             header('location: ' . URLROOT . '/' . 'posts');;
    //         }
    //     }
    // }//close deletePost




}// close class
