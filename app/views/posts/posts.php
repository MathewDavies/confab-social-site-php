<?php require APPROOT . '/views/inc/header.php';?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/feed.css">
<div class="flex-container">
<?php

// A session is required
    if (!session_id()) @session_start();
 
    // Instantiate the class
    $msg = new FlashMessages;
    //if the user has tried to login and are passed back after an error


    if($postFlash !='posts' && $postFlash!=null){
      if(array_key_exists('message', $postFlash)){
        $msg->success($postFlash['message']);
      }
      if(array_key_exists('error', $postFlash)){
        $msg->error($postFlash['error']);
      }
    }

?>       
<!--Section to Add a Post -->
<div class="add-post">
    <form action="<?php echo URLROOT; ?>/posts/addpost" id="addPost" method="POST">
    <p class="welcome-text">Hi <?php echo $_SESSION['user_name']; ?>. What do you want to say today?</p>
    <textarea name="add-post-body" rows="4" id="add-post-body" maxlength="300" autocomplete="off" wrap="soft"></textarea>
    <div class="add-post-row">
        <p id="add-post-character-count" class="character-count">0 of 300</p>
    <input type="submit"  class="add-post-btn" value="Send">
    </div>
    <?php 
    if(isset($postFlash)){
        $msg->display(); 
    }
    ?>
    </form> 
</div>
<!--Section to add the feed with PHP -->
   <?php
        //Need to convert URLROOT to a variable so it is recognised as php by the herodoc echo
        $urlRoot = URLROOT;
        // find $feedData length and define in variable
        $feedSize = sizeof($data2);
        //Loop through the feed data array and echo out the html, populating it with the relevant information
        for ($i=0; $i < $feedSize; $i++){
echo <<<EOT
        <div class="post">
        <div class="post-header">
            <img class= "profile-image" src="{$urlRoot}/public/uploads/{$data2[$i]['photo_name']}" alt="profile picture">
            <div class="post-header-text">
                <h2 class="user-name">{$data2[$i]['name']}</h2>
                <p class="handle">{$data2[$i]['handle']}</p>
            </div>
        </div> 
        <div class="post-body">
            <p>{$data2[$i]['body']}</p>
        </div>
        <div class="post-grid"> 
                <p class="post-info post-upvote-p">Upvotes: <span class="upvote-number">{$data2[$i]['upvote_count']}<span></p>
                <p class="post-info post-date">Created: {$data2[$i]['created_at']}</p>
               
            <button class="like-post-button upvoted-{$data2[$i]['upvoted']}" value="{$data2[$i]['id']}">
            &#8599
            </button>        
            <form class="goto-post-detail" method="POST" action = "{$urlRoot}/posts/postdetail">
                 <input type="hidden" name ="post_id" value="{$data2[$i]['id']}">
                 <input type="submit"  class="reply-post-btn" value="Reply">
            </form>
        </div> 
        </div>
    </div> 
    
EOT;
}

?>
    
</div>
        



<script> 
// The JS file doesn't recognise the PHP embedded whilst declaring the variable
        "user strict";
        let dataJ = <?php echo $data2; ?>;
        let user = <?php echo $data1; ?>;
        let path = ' <?php  echo URLROOT; ?>';
</script>
<script src="<?php echo URLROOT; ?>\js\helpers.js"> </script> 
<script src="<?php echo URLROOT; ?>\js\posts.js"> </script> 

<?php require APPROOT . '/views/inc/footer.php';?>