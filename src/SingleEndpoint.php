<?php

namespace Winnerpicker\Instagram;

class SingleEndpoint extends AbstractEndpoint
{
    /**
     * Выполняет API-запрос для текущего эндпоинта.
     *
     * @return array
     */
    public function makeRequest()
    {
        $responseData = $this->api->request($this->endpointUrl())->data();

        if (method_exists($this, 'transformResponse')) {
            return $this->transformResponse($responseData);
        }

        return $responseData;
    }
}
