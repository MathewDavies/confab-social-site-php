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

<header>
    <h1 class= "header-title">Confab</h1>

    <?php if(isset($_SESSION['user_id'])) : ?> 
    <span class="welcome">Hello <?php echo $_SESSION['user_name']; ?></span>
    <nav>
        <ul class="nav-list">
            <li class ="nav-item"><a class= "nav-item-link"href="http://localhost/confab/posts">Posts</a></li>
            <li class ="nav-item"><a class= "nav-item-link"href="http://localhost/confab/users/profile">Profile</a></li>
            <li class="nav-item"><a class="nav-item-link" href=<?php echo URLROOT . "/users/logout"; ?>>Logout</a></li>
        </ul>
    </nav>
    <?php else : ?>
    <p></p>
    <?php endif; ?> 




<!-- might need to change nav links as the project develops -->
</header>

<div class="container">


