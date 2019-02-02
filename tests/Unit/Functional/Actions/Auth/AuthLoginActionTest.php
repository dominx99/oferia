<?php

namespace App\Functional\Actions\Auth;

use App\Auth\Auth;
use App\BaseTestCase;
use App\DatabaseTrait;
use Firebase\JWT\JWT;

class AuthLoginActionTest extends BaseTestCase
{
    use DatabaseTrait;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->createUser([
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);
    }

    /** @test */
    public function that_login_action_works()
    {
        $response = $this->runApp('post', '/api/auth/login', [
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);

        $token  = json_decode((string) $response->getBody(), true)['token'];
        $userId = JWT::decode($token, getenv('JWT_SIGN'), ['HS256'])->user_id;

        $this->assertTrue($response->isOk());
        $this->assertEquals($this->user->id, $userId);
    }

    /**
     * @test
     * @dataProvider wrong_credentials_provider
     */
    public function that_wrong_credentials_fails($email, $password)
    {
        $response = $this->runApp('post', '/api/auth/login', [
            'email'    => $email,
            'password' => $password,
        ]);

        $this->assertTrue($response->isServerError());
    }

    public function wrong_credentials_provider()
    {
        return [
            ['test@test', 'test'],
            ['test@test.com', 'test123'],
        ];
    }
}
