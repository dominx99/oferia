<?php

namespace App\Unit\Auth;

use App\Auth\Auth;
use App\BaseTestCase;
use App\DatabaseTrait;

class AuthTest extends BaseTestCase
{
    use DatabaseTrait;

    public function setUp()
    {
        parent::setUp();

        $this->auth = $this->container->get(Auth::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->auth->logout();
    }

    /** @test */
    public function that_user_session_is_set_after_authenticate()
    {
        $this->auth->authenticate(5);

        $this->assertTrue(isset($_SESSION['user']));
        $this->assertEquals(5, $_SESSION['user']);
    }

    /** @test */
    public function that_check_function_returns_if_session_is_set()
    {
        $this->assertFalse($this->auth->check());

        $this->auth->authenticate(5);

        $this->assertTrue($this->auth->check());
    }

    /** @test */
    public function that_logout_function_works_well()
    {
        $this->auth->authenticate(5);

        $this->assertTrue($this->auth->check());

        $this->auth->logout();

        $this->assertFalse($this->auth->check());
    }

    /** @test */
    public function that_user_function_returns_user()
    {
        $user = $this->createUser();

        $this->auth->authenticate($user->id);

        $this->assertEquals($user->id, $this->auth->user()->id);
    }

    /** @test */
    public function that_attempt_works_and_user_is_authenticated()
    {
        $user = $this->createUser([
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);

        $verified = $this->auth->attempt('test@test.com', 'test');

        $this->assertTrue($verified);
        $this->assertTrue($this->auth->check());
    }
}
