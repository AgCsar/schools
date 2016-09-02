<?php

namespace Tests;

use Auth0\SDK\Auth0AuthApi;
use Illuminate\Foundation\Testing\TestCase as TestCaseLara;
use Config;

class TestCase extends TestCaseLara
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Obtem id_token de autentificação auth0 para 
     * testes de autentificação 
     * 
     * @return array
     */
    public function getAutHeader()
    {
        $tokens = $this->getTokenUserTester();
        return ['authorization' => "Bearer {$tokens['id_token']}"];
    }

    /**
     * Obtem o token_id e access_token 
     * do usuário para automatização de testes
     * 
     * 
     * @return array tokens
     */
    public function getTokenUserTester()
    {
        $auth0Api = new Auth0AuthApi(
            Config::get('laravel-auth0.domain'), 
            Config::get('laravel-auth0.client_id'), 
            Config::get('laravel-auth0.client_secret'));
        
        // $tokens = $auth0Api->authorize_with_ro(
        //     Config::get('laravel-auth0.email_user_tester'),
        //     Config::get('laravel-auth0.pass_user_tester'),
        //     'openid',
        //     'Username-Password-Authentication');

        $tokens['id_token'] = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2xvZ29zLmF1dGgwLmNvbS8iLCJzdWIiOiJhdXRoMHw1N2MwODQwZGVhZTA5NTQ3MWFiYTQwOTMiLCJhdWQiOiJ3Mjd6MXY5eFJQQnVycWFYNmxEcXNNSTJ1TldocXgwdiIsImV4cCI6MTQ3NTQzMDg0MCwiaWF0IjoxNDcyODM4ODQwfQ.xf850xY3eDNmofQm2fy9WOA9eyr4vL5EXRqWotD0xG8";
        
        return $tokens;
    }
}
