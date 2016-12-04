<?php

namespace Winnerpicker\Instagram\Contracts;

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
     * @param array  $params    = []
     * @param bool   $useRawUrl = false
     *
     * @return \stdClass
     */
    public function request(string $url, array $params = [], bool $useRawUrl = false);
}
