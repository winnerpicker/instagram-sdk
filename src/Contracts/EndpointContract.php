<?php

namespace Winnerpicker\Instagram\Contracts;

interface EndpointContract
{
    /**
     * Возвращает начальный URL эндпоинта.
     *
     * @return string
     */
    public function endpointUrl(): string;

    /**
     * Выполняет API-запрос для текущего эндпоинта.
     *
     * @return mixed
     */
    public function makeRequest();

    /**
     * Возвращет инстанс API-ответа.
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    public function apiResponse();
}
