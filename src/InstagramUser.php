<?php

namespace Winnerpicker\Instagram;

use Winnerpicker\Instagram\Contracts\InstagramUserContract;

class InstagramUser implements InstagramUserContract
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param int    $id
     * @param string $token
     */
    public function __construct(int $id, string $token)
    {
        $this->id = $id;
        $this->token = $token;
    }

    /**
     * ID пользователя.
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * API-токен пользователя.
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }
}
