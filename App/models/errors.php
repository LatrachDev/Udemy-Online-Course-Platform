<?php
    function set_error($key, $message)
    {
        $_SESSION['errors'][$key] = $message;
    }
    
    function get_error($key)
    {
        $error = $_SESSION['errors'][$key] ?? null;
        unset($_SESSION['errors'][$key]);
        return $error;
    }
    
    function has_error($key)
    {
        return isset($_SESSION['errors'][$key]);
    }
    
    function abort($code)
    {
        if ($code === 404) 
        {
            require 'App/views/errors/404.php';
            exit;
        } 
        else if ($code === 403) 
        {
            require 'App/views/errors/403.php';
            exit;
        } 
        else if ($code === 500) 
        {
            require 'App/views/errors/500.php';
            exit;
        } 
    }
?> 