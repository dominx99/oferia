<?php

namespace App\Functional\Actions\Auth;

use App\Auth\Auth;
use App\BaseTestCase;
use App\DatabaseTrait;
use App\Services\Api\StatusMessage;
use Firebase\JWT\JWT;
use Slim\Http\StatusCode;

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

        $this->assertEquals(StatusCode::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /** @test */
    public function that_not_valid_credentials_returns_errors()
    {
        $response = $this->runApp('post', '/api/auth/login', [
            'email' => 'test@test.com',
        ]);

        $responseData = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('errors', $responseData);
        $this->assertEquals(StatusMessage::VALIDATION_ERROR, $responseData['status']);
        $this->assertEquals(StatusCode::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function wrong_credentials_provider()
    {
        return [
            ['test@test', 'test'],
            ['test@test.com', 'test123'],
        ];
    }
}
