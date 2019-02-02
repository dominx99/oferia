<?php

namespace App;

use App\Models\User;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class BaseTestCase extends TestCase
{
    protected $app;

    protected $container;

    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->app       = $this->createApplication();
        $this->container = $this->app->getContainer();
        $this->faker     = Factory::create();

        $traits = array_flip(class_uses_recursive(static::class));
        if (isset($traits[DatabaseTrait::class])) {
            $this->migrate();
        }
    }

    public function tearDown()
    {
        parent::tearDown();

        $traits = array_flip(class_uses_recursive(static::class));
        if (isset($traits[DatabaseTrait::class])) {
            $this->rollback();
        }
    }

    public function createApplication(): App
    {
        return new App('.env.testing');
    }

    public function createUser($overrides = []): User
    {
        $credentials = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        $credentials = array_merge($credentials, $overrides);

        $credentials['password'] = password_hash($credentials['password'], PASSWORD_BCRYPT);

        return User::create($credentials);
    }

    public function request(array $options, array $params): Request
    {
        $default = [
            'content_type' => 'application/json',
            'method'       => 'get',
            'uri'          => '/',
        ];

        $options = array_merge($default, $options);

        $env          = Environment::mock();
        $uri          = Uri::createFromString($options['uri']);
        $headers      = Headers::createFromEnvironment($env);
        $cookies      = [];
        $serverParams = $env->all();
        $body         = new RequestBody();

        $request = new Request($options['method'], $uri, $headers, $cookies, $serverParams, $body);
        $request = $request->withParsedBody($params);
        $request = $request->withHeader('Content-Type', $options['content_type']);
        $request = $request->withMethod($options['method']);

        return $request;
    }

    public function runApp(string $method, string $uri, array $params = [], array $options = [])
    {
        $options['method'] = $method;
        $options['uri']    = $uri;

        $request = $this->request($options, $params);

        return $this->app->process($request, new Response());
    }
}
