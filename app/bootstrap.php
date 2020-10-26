<?php
//Load Config
require_once 'config/config.php';

//Load Session Helper
require_once 'helpers/sessions.php';


//AutoLoad Core Libraries

spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});

