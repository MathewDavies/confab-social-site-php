<?php require APPROOT . '/views/inc/headerlogin.php';?> 
 
  </head>
  <?php 
  //Logic to create Flash messages
  //The function is run below where we want the messages to appear

  // A session is required
    if (!session_id()) @session_start();
 
    // Instantiate the class
    $msg = new FlashMessages;
    //if the user has tried to login and are passed back after an error
    if($data['type']==='login'){
      if($data['email_handle_err']!=null){
        $msg->error($data['email_handle_err']); 
      }
      if($data['password_err']!=null){
          $msg->error($data['password_err']); 
        }
    //if the user has tried to register and are passed back after an error
    }else if($data['type']==='register'){

    
    //if there is an error in the name variable, create an error message
    if($data['name_err']!=null){
      $msg->error($data['name_err']); 
    }
    if($data['handle_err']!=null){
        $msg->error($data['handle_err']); 
      }
      if($data['email_err']!=null){
        $msg->error($data['email_err']); 
      }
      if($data['password_err']!=null){
        $msg->error($data['password_err']); 
      }
      if($data['confirm_password_err']!=null){
        $msg->error($data['confirm_password_err']); 
      }
  }else{
    //do nothing
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">
<div class="hero">

<div class="hero-text">
  <h1>Confab</h1>
  <h2>The Work Place Discussion Board</h2>
  <br>
  <p>Confab is a creative space where colleagues can share knowledge and ideas to increase productivity. You can register for free so why not check it out?</p>

</div>
        <div id ="form-box" class="form-box delete">
             <div class="button-box">
                <span id="btn"></span>
                <button class='toggle-btn' onclick='displayLogin()'>Log In</button>
                <button class='toggle-btn' onclick='displayRegister()'>Register</button>
            </div>
            <form class="input-group" action="<?php echo URLROOT; ?>/users/index" id="login" method="post">
                <input type="text" name="login-name" class="input-field " title="enter your name" placeholder="Email/Handle" required>
                <input type="password" name="login-password" class="input-field" placeholder="Password" required>
                <input type="hidden" name="type" value="login">
                <input type="submit"  class="submit-btn" value="Log in">
                <?php
//Run the method to create the flash messages
if($data['type']==='login'){
$msg->display();
}
?>
            </form>   
            <form class="input-group" action="<?php echo URLROOT; ?>/users/index" id="register" method="post">
                <input type="text" id="register-name" name="register-name" class="input-field" placeholder="Name" required>
                <input type="text" id="register-handle" name="register-handle" class="input-field" placeholder="Handle" required>
                <input type="email" id="register-email" name="register-email" class="input-field" placeholder="Email" required>
                <input type="password" id="register-password" name="register-password" class="input-field" placeholder="Password" required>
                <input type="password" id="register-confirm" name="register-confirm" class="input-field" placeholder="Confirm Password" required>
                <input type="hidden" id="type" name="type" value="register">
                <input type = 'submit' class="submit-btn" value = 'Register'/>
<?php
//Run the method to create the flash messages
if($data['type']==='register'){
$msg->display();
}
?> 
<?php if ($data['register_success'] != null){ echo "<div class='success'>". $data['register_success']. "</div>";}?>

                <p id="register-result"></p>
            </form>
        </div>
    </div>
<script>
    let side = "<?php echo $data['type']; ?>"
</script>    
<script src="<?php echo URLROOT; ?>\js\login.js"> </script>
<?php require APPROOT . '/views/inc/footer.php';?>