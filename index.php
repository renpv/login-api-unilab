<?php
use Renpv\LoginApiUnilab\Login;

require __DIR__ . '/vendor/autoload.php';


$login = new Login();

$user = $login->attempt('renatopaiva', '');
var_dump($user);





