<?php

namespace Renpv\LoginApiUnilab;

class User
{
    private $dataUser;

    public function __construct($dataUser)
    {
        $this->dataUser = $dataUser;
    }

    public function getIdPeople()
    {
        return $this->dataUser[0]->id_pessoa;
    }

    public function getIdUser()
    {
        return $this->dataUser[0]->id_usuario;
    }

    public function getName()
    {
        return $this->dataUser[0]->nome;
    }

    public function getCpf()
    {
        return (string) $this->dataUser[0]->cpf_cnpj;
    }

    public function getEmail()
    {
        return $this->dataUser[0]->email;
    }

    public function getUserLogin()
    {
        return $this->dataUser[0]->login;
    }

    public function isTeacherActive()
    {
        foreach ($this->dataUser as $user) {
            if ($user->id_status_servidor == 1 && $user->id_categoria == 1) {
                //id_status_servidor precisa ser 1 (Ativo)
                //id_categoria precisa ser 1 (Docente)
                return true;
            }
        }
        return false;
    }

    public function isTechnicalActive()
    {
        foreach ($this->dataUser as $user) {
            if ($user->id_status_servidor == 1 && $user->id_categoria == 2) {
                //id_status_servidor precisa ser 1 (Ativo)
                //id_categoria precisa ser 2 (Técnico Administrativo)
                return true;
            }
        }
        return false;
    }

    public function isScholarshipActive()
    {
        foreach ($this->dataUser as $user) {
            if ($user->matricula_disc != null && in_array($user->id_status_discente, [1, 8])) {
                //Matrícula precisa estar preenchida para saber se o usuário é aluno no sistema
                //id_status_discente precisa ser 1 (Ativo) ou 8 (Formando)
                return true;
            }
        }
        return false;
    }
}