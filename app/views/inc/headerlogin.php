<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <script src="https://kit.fontawesome.com/54a7f48eef.js" crossorigin="anonymous"></script>
    <title><?php echo SITENAME ?></title>
</head>
<body>

<div class="login-header">
    <?php if(isset($_SESSION['user_id'])) : ?> 
    
    <a class="btn-logout" href=<?php echo URLROOT . "/users/logout"; ?>>Logout</a>
    <?php else : ?>
    <p></p>
    <?php endif; ?> 




<!-- might need to change nav links as the project develops -->
</div>

<div class="container">


