<?php

namespace Renpv\LoginApiUnilab;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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

    public function attempt(string $user, string $pass)
    {
        $token = $this->authenticate($user, $pass);
        if (isset($token->error))
            return $token;

        if (isset($token->access_token)) {
            $bond = $this->getBond($token->access_token);
            var_dump($bond);
        }
    }

    private function authenticate($user, $pass)
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
    private function getErrorMessage($stringError)
    {
        $message['error'] = true;
        $message['message'] = 'Erro desconhecido';

        preg_match('/`(\d{3}) /', $stringError, $matches);

        if ($matches[1] == '401') {
            $message['message'] = "Usuário ou senha incorretos";
        }

        return (object) $message;
    }
}