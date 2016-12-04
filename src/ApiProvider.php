<?php

namespace Winnerpicker\Instagram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;
use Winnerpicker\Instagram\Contracts\ApiProviderContract;

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
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(string $token, LoggerInterface $logger)
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
     * @param array  $params    = []
     * @param bool   $useRawUrl = false
     *
     * @return array | null
     */
    public function request(string $url, array $params = [], bool $useRawUrl = false)
    {
        if ($useRawUrl === false) {
            if (!isset($param['query'])) {
                $params['query'] = [];
            }

            $params['query']['access_token'] = $this->token;
        }

        try {
            $response = $this->getClient()->request('GET', $url, $params);
        } catch (RequestException $e) {
            $this->logger->debug('[ApiProvider#request] Got RequestException', [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
            ]);

            return;
        }

        $body = $response->getBody();

        if (empty($body)) {
            $this->logger->debug('[ApiProvider#request] Got empty response', [
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
            ]);

            return;
        }

        $json = json_decode($body, true);

        if (empty($json)) {
            $this->logger->debug('[ApiProvider#request] Got response but json is empty', [
                'url' => $url,
                'params' => $params,
                'token' => $this->token,
                'body' => $body,
            ]);

            return;
        }

        return $json;
    }
}
