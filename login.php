<?php
session_start();
require_once 'inc/functions.inc.php';
require_once 'lang/en.php'; //default language
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo __('login'); ?></title>
    <link type="text/css" href="css/style.css" rel="stylesheet"/>
</head>
<body>
<div id="container">
<form method="post" action="index.php">
    <h1><?php echo __('login'); ?></h1>
    <p><?php echo __('login.user'); ?>:<br><input type="text" name="user"></p>
    <p><?php echo __('login.password'); ?>:<br><input type="password" name="password"></p>
    <input type="submit" value="<?php echo __('login'); ?>">
</form>
</div>
</body>
</html>