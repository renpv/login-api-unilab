<?php
use Renpv\LoginApiUnilab\Login;

require __DIR__ . '/vendor/autoload.php';


$login = new Login();

$user = $login->attempt('renatopaiva', '');
var_dump($user->getName());
var_dump($user->getCpf());
var_dump($user->getEmail());
var_dump($user->getIdPeople());
var_dump($user->getIdUser());
var_dump($user->getUserLogin());
var_dump($user->isTeacherActive());
var_dump($user->isTechnicalActive());
var_dump($user->isScholarshipActive());





