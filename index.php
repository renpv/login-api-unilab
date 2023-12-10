<?php
use Renpv\LoginApiUnilab\Login;

require __DIR__ . '/vendor/autoload.php';


$login = new Login();

$user = $login->attempt('usuarioSig', 'senhaUsuario');

if ($user->error) {
    echo "O sistema retornou o seguinte erro: " . $user->message;
} else {
    echo $user;
}






