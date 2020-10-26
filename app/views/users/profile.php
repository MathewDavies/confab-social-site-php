<?php require APPROOT . '/views/inc/header.php';?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/profile.css"> 
 
  </head>
<?php
//create flash messages if approriate

// A session is required
    if (!session_id()) @session_start();
   // Instantiate the class
    $msg = new FlashMessages;
    //if the user has tried to login and are passed back after an error
    if($profileFlash != null){
      if(array_key_exists('success', $profileFlash)){
        $msg->success($profileFlash['success']);
      }
      if(array_key_exists('error', $profileFlash)){
        $msg->error($profileFlash['error']);
      }
    }
?> 
<!-- Need to show user name, handle, email and picture
This needs a database query on subscriber_id 
later on you can create stats such as likes, likes per post, etc.  
-->
<div class="profile-page">
    <h1>Profile</h1>
<?php
$urlRoot = URLROOT;
echo <<<EOT

        <div class="profile-container">
          <div class="profile-image-container">    
            <img class= "profile-image" src="{$urlRoot}/public/uploads/{$profileInformation[0]['photo_name']}" alt="profile picture">
            <form action="{$urlRoot}/users/uploadPhoto" method="POST" enctype="multipart/form-data">
                <h3>Update Profile Photo</h3>
                <input class="choose-photo-btn" type="file" name="file">
                <input type="hidden" name="type" value="photo-upload">
                <button class="photo-btn" type="submit" name="photo-submit">Upload</button>
            </form>
          </div>

          <div class="profile-information">
            <h2>{$profileInformation[0]['name']}</h2>
                <p>Handle: {$profileInformation[0]['handle']}</p>
                <p>Email: {$profileInformation[0]['email']}</p>
                <p>Joined: {$profileInformation[0]['created_at']}</p>
                <p>Posts: {$profileInformation[1]}</p>
                <p>Upvotes on Posts: {$profileInformation[2]}</p>
                <p>Upvotes per Post: {$profileInformation[3]}</p>
                <p>Replies: {$profileInformation[4]}</p>
                <p>Upvotes on Replies: {$profileInformation[5]}</p>
                <p>Upvotes per Reply: {$profileInformation[6]}</p>
            </div>
        </div>
EOT;
    ?>
    
<?php

if(isset($profileFlash)){
        $msg->display(); 
    }
?>
  <!-- <script src="<?php echo URLROOT; ?>\js\profile.js"> </script> -->
  <?php require APPROOT . '/views/inc/footer.php';?>