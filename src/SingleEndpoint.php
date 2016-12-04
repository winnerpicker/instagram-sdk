<?php

namespace Winnerpicker\Instagram;

class SingleEndpoint extends AbstractEndpoint
{
    /**
     * Выполняет API-запрос для текущего эндпоинта.
     *
     * @return mixed
     */
    public function makeRequest()
    {
        return $this->api->request($this->endpointUrl());
    }
}
