<?php

namespace App\Auth;

use App\Auth\Auth;
use App\BaseTestCase;

class AuthTest extends BaseTestCase
{
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

    /**
     * @test
     */
    public function that_user_session_is_set_after_authorize()
    {
        $this->auth->authorize(5);

        $this->assertTrue(isset($_SESSION['user']));
        $this->assertEquals(5, $_SESSION['user']);
    }

    /**
     * @test
     */
    public function that_check_function_returns_if_session_is_set()
    {
        $this->assertFalse($this->auth->check());

        $this->auth->authorize(5);

        $this->assertTrue($this->auth->check());
    }

    /**
     * @test
     */
    public function that_logout_function_works_well()
    {
        $this->auth->authorize(5);

        $this->assertTrue($this->auth->check());

        $this->auth->logout();

        $this->assertFalse($this->auth->check());
    }
}
