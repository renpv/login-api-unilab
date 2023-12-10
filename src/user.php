<?php

namespace Renpv\LoginApiUnilab;

class User
{
    private $dataUser;
    public $error = false;

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

    /**
     * Função que retorna qual a unidade o usuário está vinculado
     */
    public function getUnity()
    {
        return $this->dataUser[0]->sigla_unidade;
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

    /**
     * Método que retorna se o usuário é do tipo terceirizado
     */
    public function isOutsourced()
    {
        foreach ($this->dataUser as $user) {
            if ($user->id_tipo_usuario == 12) {
                //id_tipo_usuario precisa ser 12 (Terceirizado)
                return true;
            }
        }
        return false;
    }

    public function isActiveInSystem()
    {
        foreach ($this->dataUser as $user) {
            if ($user->status_sistema == 1) {
                //id_status_sistema precisa ser 1 (Ativo)
                return true;
            }
        }
        return false;
    }

    public function __toString()
    {
        //Definindo as mensagens básicas
        $definition = [
            "Nome completo do usuário:" => $this->getName(),
            "Login do usuário:" => $this->getUserLogin(),
            "E-mail do usuário:" => $this->getEmail(),
            "CPF do usuário:" => $this->getCpf(),
            "ID do usuário no Sig:" => $this->getIdUser(),
            "ID da pessoa no Sig:" => $this->getIdPeople(),
            "Unidade de vínculo do usuário:" => $this->getUnity(),
            "É docente ativo?" => ($this->isTeacherActive() ? 'Sim' : 'Não'),
            "É técnico ativo?" => ($this->isTechnicalActive() ? 'Sim' : 'Não'),
            "É terceirizado?" => ($this->isOutsourced() ? 'Sim' : 'Não'),
            "É aluno ativo?" => ($this->isScholarshipActive() ? 'Sim' : 'Não'),
            "Está ativo no sistema?" => ($this->isActiveInSystem() ? 'Sim' : 'Não'),
        ];

        //Verificando se o código está sendo chamado no terminal ou navegador
        $break = (defined('STDIN') ? "\n" : "<br>");

        //Montando a saída
        $output = "";
        foreach ($definition as $key => $value) {
            $output .= sprintf("${key} %s ${break}", $value);
        }

        //Retorno
        return $output;
    }
}