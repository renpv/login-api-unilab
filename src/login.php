<?php

namespace Renpv\LoginApiUnilab;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Login
{
    private $token;
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.unilab.edu.br/api/',
            'verify' => false
        ]);
    }

    /**
     * Função que controla as tentativas de login
     * @param string $user
     * @param string $pass
     * 
     * @return stdClass|User|boolean stdClass quando houver algum erro, string quando o usuário for validado
     */
    public function attempt(string $user, string $pass)
    {
        $token = $this->authenticate($user, $pass);

        if (isset($token->error))
            return $token; //Erro

        if (isset($token->access_token)) {
            $bond = $this->getBond($token->access_token);
            return new User($bond);
        }
        return false;
    }

    /**
     * Função que retorna os dados do usuário
     * @param string $user
     * @param string $pass
     * 
     * @return stdClass|string stdClass quando houver algum erro, string quando o usuário for validado
     */
    private function authenticate(string $user, string $pass)
    {
        $request = new Request('POST', 'authenticate');

        $options = [
            'multipart' => [
                [
                    'name' => 'login',
                    'contents' => $user
                ],
                [
                    'name' => 'senha',
                    'contents' => $pass
                ]
            ]];

        try {
            $return = $this->client->send($request, $options);
            $contents = json_decode($return->getBody()->getContents());
            if (is_string($contents))
                return $this->getErrorMessage($contents);
            return $contents;

        } catch (\Throwable $th) {
            return $this->getErrorMessage($th->getMessage());
        }
    }

    /**
     * Função que retorna os dados do usuário
     * @param string $token
     * 
     * @return stdClass|string stdClass quando houver algum erro, String quando o login tiver sucesso
     */
    private function getBond(string $token)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $request = new Request('GET', 'bond', $headers);

        try {
            $return = $this->client->send($request);
            $contents = json_decode($return->getBody()->getContents());
            if (is_string($contents))
                return $this->getErrorMessage($contents);
            return $contents;

        } catch (\Throwable $th) {
            return $this->getErrorMessage($th->getMessage());
        }
    }

    /**
     * Função que retorna o erro capturado na tentativa de login na API
     * @param string $stringError
     * 
     * @return stdClass {error: boolean, message: string}
     */
    private function getErrorMessage(string $stringError): stdClass
    {
        $message['error'] = true;
        $message['message'] = 'Erro desconhecido';

        preg_match('/`(\d{3}) /', $stringError, $matches);

        if ($matches[1] == '422') {
            $message['message'] = "Você deve informar uma senha";
        }

        if ($matches[1] == '401') {
            $message['message'] = "Usuário ou senha incorretos";
        }

        $t = (object) $message;

        return $t;
    }
}