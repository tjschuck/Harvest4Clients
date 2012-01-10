<?php
function login($clients)
{
    if (isset($_SESSION['user']) && array_key_exists($_SESSION['user'], $clients))
    {
        return true; //already logged in
    }
    elseif ( $_SERVER['REQUEST_METHOD'] == 'POST'
        && isset($_POST['user'])
        && isset($_POST['password'])
        && array_key_exists($_POST['user'], $clients)
    )
    {
        //check login data
        $user = $_POST['user'];

        if($_POST['password'] == $clients[$user]['password'])
        {
            $_SESSION['user'] = $user;
        }
        header('Location: index.php');
        exit;
    }

    //not logged in
    unset($_SESSION['user']);
    return false;
}

if( !login($clients) )
{
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
include('lang/'.$clients[$user]['language'].'.php');

if(isset($_GET['logout']))
{
    unset($_SESSION['user']);
    header('Location: login.php');
    exit;
}