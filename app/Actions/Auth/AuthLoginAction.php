<?php

namespace App\Actions\Auth;

use App\Auth\Auth;
use App\Auth\Token;
use App\Models\User;
use App\Services\Api\ApiHelpers;
use App\Services\Api\StatusMessage;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\Validator;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

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
     * @var \Rakit\Validation\Validator
     */
    protected $validator;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->auth      = $container->get(Auth::class);
        $this->token     = $container->get(Token::class);
        $this->validator = $container->get(Validator::class);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $validation = $this->validator->make($request->getParams(), [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $this->respondError(
                StatusMessage::VALIDATION_ERROR,
                StatusCode::HTTP_BAD_REQUEST,
                ['errors' => $validation->errors()->toArray()]
            );
        }

        if (!$this->auth->attempt($request->getParam('email'), $request->getParam('password'))) {
            return $this->respondError(StatusMessage::INVALID_CREDENTIALS);
        }

        if (!$user = $this->auth->user()) {
            return $this->respondError();
        }

        return $this->respondOk([
            'token' => $this->token->fromUser($user),
        ]);
    }
}
