# LOGIN API SIG/Unilab

Pacote para auxiliar no processo de login utilizando a API de Login no Sig, disponível em https://api.unilab.edu.br

## INSTALAÇÃO

Para instalar este pacote utilize o seguinte comando:

```sh
composer require renpv/login-api-unilab
```

## UTILIZAÇÃO

Após a instalação, você precisa importar o pacote. Para isso, utilize o seguinte código.

```php
<?php

use Renpv\LoginApiUnilab\Login;

$login = new Login();

$user = $login->attempt('usuarioSig', 'senhaUsuario');

if ($user->error) {
    echo "O sistema retornou o seguinte erro: " . $user->message;
} else {
    echo $user;
}

```

## MÉTODOS DISPONÍVEIS

Na versão atual, estão disponíveis os seguintes métodos

```php
// Retorna o nome completo do usuário
$user->getName();
//Login do usuário
$user->getUserLogin();
//E-mail do usuário
$user->getEmail();
//CPF do usuário
$user->getCpf();
//ID do usuário no Sig
$user->getIdUser();
//ID da pessoa no Sig
$user->getIdPeople();
//É docente ativo
$user->isTeacherActive();
//É técnico ativo
$user->isTechnicalActive();
//É aluno ativo
$user->isScholarshipActive();

```
