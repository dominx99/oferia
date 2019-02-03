<?php

namespace App\Auth;

use App\Models\User;
use Firebase\JWT\JWT;

class Token
{
    /**
     * @var string $iss
     */
    protected $iss;

    /**
     * @var string $aud
     */
    protected $aud;

    /**
     * @var string $sign
     */
    protected $sign;

    /**
     * @var array $allowed_algs
     */
    protected $algs;

    public function __construct()
    {
        $this->iss  = getenv('APP_URL');
        $this->aud  = getenv('APP_URL');
        $this->sign = getenv('JWT_SIGN');
        $this->algs = ['HS256'];
    }

    /**
     * @param User $user
     * @return string
     */
    public function fromUser(User $user): string
    {
        $payload = array_merge($this->getPayload(), ['user_id' => $user->id]);

        return JWT::encode($payload, $this->sign);
    }

    /**
     * @param string $token
     * @return \App\Models\User
     */
    public function getUser(string $token): User
    {
        $payload = JWT::decode($token, $this->sign, $this->algs);

        return User::find($payload->user_id);
    }

    /**
     * TODO: Make expiration time configurable
     * @return array
     */
    protected function getPayload(): array
    {
        return [
            'iss' => $this->iss,
            'aud' => $this->aud,
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 3600,
        ];
    }
}
