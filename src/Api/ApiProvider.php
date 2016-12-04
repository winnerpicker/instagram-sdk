<?php

namespace Winnerpicker\Instagram\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Winnerpicker\Instagram\Contracts\Api\ApiProviderContract;
use Winnerpicker\Instagram\Exceptions\EmptyApiResponseException;

class ApiProvider implements ApiProviderContract
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param string                   $token
     * @param \Psr\Log\LoggerInterface $logger = null
     */
    public function __construct(string $token, LoggerInterface $logger = null)
    {
        $this->token = $token;
        $this->logger = $logger;
    }

    /**
     * Возвращает API-токен пользователя.
     *
     * @return string
     */
    public function token(): string
    {
        return $this->token;
    }

    /**
     * Ленивый загрузчик HTTP-клиента.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        if (!is_null($this->client)) {
            return $this->client;
        }

        return $this->client = new Client([
            'base_uri' => 'https://api.instagram.com/',
        ]);
    }

    /**
     * Выполняет запрос к переданному URL.
     *
     * @param string $url
     * @param array  $params      = []
     * @param bool   $usingRawUrl = false
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    public function request(string $url, array $params = [], bool $usingRawUrl = false)
    {
        if ($usingRawUrl === false) {
            if (!isset($param['query'])) {
                $params['query'] = [];
            }

            $params['query']['access_token'] = $this->token;
        }

        try {
            $response = $this->getClient()->request('GET', $url, $params);
        } catch (RequestException $e) {
            $this->debug('[ApiProvider#request] Got RequestException', [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
            ]);

            return $this->transformResponse($e->getResponse());
        }

        return $this->transformResponse($response);
    }

    /**
     * Трансформирует данные запроса в объек ответа API.
     *
     * @param \Psr\Http\Message\ResponseInterface $response = null
     *
     * @throws \Winnerpicker\Instagram\Exceptions\EmptyApiResponseException
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    protected function transformResponse(ResponseInterface $response = null)
    {
        if (is_null($response)) {
            throw new EmptyApiResponseException('API Request ended in empty response.');
        }

        $body = $response->getBody();
        $rateLimit = intval($response->getHeader('X-RateLimit-Limit'));
        $rateLimitRemaining = intval($response->getHeader('X-RateLimit-Remaining'));

        $apiResponse = new ApiResponse($rateLimit, $rateLimitRemaining);

        if (empty($body)) {
            $this->debug('[ApiProvider#request] Got empty response', [
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
            ]);

            return $apiResponse;
        }

        $json = json_decode($body, true);

        if (empty($json)) {
            $this->debug('[ApiProvider#request] Got response but json is empty', [
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
                'body' => $body,
            ]);

            return $apiResponse;
        }

        return $apiResponse->setResponseData($json);
    }

    /**
     * Записывает данные в дебаг-лог (если возможно).
     *
     * @param string $message
     * @param array  $context = []
     */
    protected function debug($message, array $context = [])
    {
        if (is_null($this->logger)) {
            return;
        }

        $this->logger->debug($message, $context);
    }
}
