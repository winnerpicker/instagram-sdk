<?php

namespace Winnerpicker\Instagram;

use Winnerpicker\Instagram\Contracts\PaginationEndpointContract;

abstract class PaginationEndpoint extends AbstractEndpoint implements PaginationEndpointContract
{
    /**
     * @var bool
     */
    protected $resetUrlAtNextRequest = false;

    /**
     * Индикатор пагинации. Используется в качестве условия для цикла.
     *
     * @return bool
     */
    public function paginate(): bool
    {
        $this->makeRequest();

        return !is_null($this->url);
    }

    /**
     * Выполняет API-запрос для текущего эндпоинта.
     *
     * @return mixed
     */
    public function makeRequest()
    {
        if (is_null($this->url)) {
            return;
        }

        if ($this->resetUrlAtNextRequest === true) {
            $this->resetUrlAtNextRequest = false;

            return $this->url = null;
        }

        $this->response = $this->api->request($this->url, [], true);

        $nextUrl = array_get($this->response, 'pagination.next_url');

        if (!is_null($nextUrl)) {
            return $this->url = $nextUrl;
        }

        return $this->resetUrlAtNextRequest = true;
    }

    /**
     * Ответ текущего эндпоинта.
     *
     * @return array
     */
    public function response(): array
    {
        $responseData = array_get($this->response, 'data', []);

        if (method_exists($this, 'transformResponse')) {
            return $this->transformResponse($responseData);
        }

        return $responseData;
    }
}
