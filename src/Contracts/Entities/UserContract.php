<?php

namespace Winnerpicker\Instagram\Contracts\Entities;

interface UserContract
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
