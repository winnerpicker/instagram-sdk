<?php

namespace Winnerpicker\Instagram\Contracts\Api;

interface ApiProviderContract
{
    /**
     * Возвращает API-токен пользователя.
     *
     * @return string
     */
    public function token(): string;

    /**
     * Выполняет запрос к переданному URL.
     *
     * @param string $url
     * @param array  $params      = []
     * @param bool   $usingRawUrl = false
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    public function request(string $url, array $params = [], bool $usingRawUrl = false);
}
