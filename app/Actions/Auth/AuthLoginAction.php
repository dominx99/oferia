<?php

namespace App\Actions\Auth;

use App\Auth\Auth;
use App\Auth\Token;
use App\Models\User;
use App\Services\Api\ApiHelpers;
use App\Services\Api\StatusMessage;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthLoginAction
{
    use ApiHelpers;

    /**
     * @var \App\Auth\Auth
     */
    protected $auth;

    /**
     * @var \App\Auth\Token
     */
    protected $token;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->auth  = $container->get(Auth::class);
        $this->token = $container->get(Token::class);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        if (!$this->auth->attempt($request->getParam('email'), $request->getParam('password'))) {
            return $this->respondError(StatusMessage::INVALID_CREDENTIALS);
        }

        $user = $this->auth->user();

        return $this->respondOk([
            'token' => $this->token->fromUser($user),
        ]);
    }
}
