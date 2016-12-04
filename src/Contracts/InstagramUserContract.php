<?php

namespace Winnerpicker\Instagram\Contracts;

interface InstagramUserContract
{
    /**
     * ID пользователя.
     *
     * @return int
     */
    public function id(): int;

    /**
     * API-токен пользователя.
     *
     * @return string
     */
    public function token(): string;
}
