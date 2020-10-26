<?php require APPROOT . '/views/inc/header.php';?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/feed.css">
<?php 
//Need to convert URLROOT to a variable so it is recognised as php by the herodoc echo
$urlRoot = URLROOT;

    if(isset($postFlash)){
        $msg->display(); 
    }
    ?>
<?php
echo<<<EOT
<div class="post">
        <div class="post-header">
            <img class= "profile-image" src="{$urlRoot}/public/uploads/{$data1['photo_name']}" alt="profile picture">
            <div class="post-header-text">
                <h2 class="user-name">{$data1['name']}</h2>
                <p class="handle">{$data1['handle']}</p>
            </div>
        </div> 
        <div class="post-body">
            <p>{$data1['body']}</p>
            <div class="post-info post-info-flex"> 
                <p class="post-date">Upvotes: {$data1['upvote_count']}</p>
                <p class="post-date">Created: {$data1['created_at']}</p>
            </div>    
        </div>
    </div>
EOT;
?>
    

<?php
        
        // find $feedData length and define in variable
        $feedSize = sizeof($data2);
        //Loop through the feed data array and echo out the html, populating it with the relevant information
        for ($i=0; $i < $feedSize; $i++){
echo <<<EOT
        <div class="post reply">
        <div class="post-header">
            <img class= "profile-image" src="{$urlRoot}/public/uploads/{$data2[$i]['photo_name']}" alt="profile picture">
            <div class="post-header-text">
                <h2 class="user-name">{$data2[$i]['name']}</h2>
                <p class="handle">{$data2[$i]['handle']}</p>
            </div>
        </div> 
        <div class="post-body">
            <p>{$data2[$i]['body']}</p>
            <div class="post-info post-info-flex"> 
                <p class="post-date">Upvotes: <span class="upvote-number">{$data2[$i]['upvote_count']}<span></p>
                <p class="post-date">Created: {$data2[$i]['created_at']}</p>
            </div>    
        </div>
        <div class="icon-row">
            <button class="like-post-button upvoted-{$data2[$i]['upvoted']}" value="{$data2[$i]['id']}">
            &#8599
            </button>
        </div>
    </div> 
EOT;
}
?>

<!--Section to Add a Post -->
<div class="add-post add-post-reply">
    <form action="<?php echo URLROOT; ?>/posts/addreply" id="addPost" method="POST">
    <textarea name="add-reply-body" rows="4" id="add-post-body" maxlength="300" autocomplete="off" ></textarea>
    <input type="hidden" name="post_id" value = <?php echo $data1['id']?> >
    <div class="add-post-row">

    <p id="add-post-character-count" class="character-count">0 of 300</p>
    <input type="submit"  class="add-post-btn" value="Send">
    </div>
    </form> 
</div>


<script>
let path = ' <?php  echo URLROOT; ?>';
let user = <?php echo $_SESSION['user_id']; ?>;
</script>
<script src="<?php echo URLROOT; ?>\js\helpers.js"> </script> 
<script src="<?php echo URLROOT; ?>\js\postdetail.js"> </script>

<?php require APPROOT . '/views/inc/footer.php';?>