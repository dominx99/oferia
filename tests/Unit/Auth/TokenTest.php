<?php

namespace App\Unit\Auth;

use App\Auth\Token;
use App\BaseTestCase;
use App\DatabaseTrait;
use Firebase\JWT\JWT;

class TokenTest extends BaseTestCase
{
    use DatabaseTrait;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->token = $this->container->get(Token::class);
    }

    /** @test */
    public function that_token_is_correct()
    {
        $user = $this->createUser();

        $token = $this->token->fromUser($user);

        $payload = JWT::decode($token, getenv('JWT_SIGN'), ['HS256']);

        $this->assertEquals(getenv('APP_URL'), $payload->iss);
        $this->assertEquals(getenv('APP_URL'), $payload->aud);
        $this->assertEquals($user->id, $payload->user_id);

        $tokenUser = $this->token->getUser($token);

        $this->assertEquals($user->id, $tokenUser->id);
    }
}
