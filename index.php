<?php
use Renpv\LoginApiUnilab\Login;

require __DIR__ . '/vendor/autoload.php';


$login = new Login();

$user = $login->attempt('renatopaiva', 'Mi2906');
var_dump($user);





