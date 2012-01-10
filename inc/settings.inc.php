<?php
//Your Harvest domain
$domain = 'https://yourdomain.harvestapp.com/';

//email:password of your Harvest account
$credentials = "example@example.com:mypass";

//key = username
//options array = password, client id, language
$clients = array(
    'user1' => array('password' => 'pwofuser', 'client' => 123456, 'language' => 'en'),
    'user2' => array('password' => 'mypassword', 'client' => 987654, 'language' => 'nl')
);
