<?php

namespace Winnerpicker\Instagram\Api;

use Winnerpicker\Instagram\Contracts\Api\ApiResponseContract;

class ApiResponse implements ApiResponseContract
{
    /**
     * @var int
     */
    const META_CODE_OK = 200;

    /**
     * @var array
     */
    protected $responseData;

    /**
     * @var int
     */
    protected $rateLimit;

    /**
     * @var int
     */
    protected $rateLimitRemaining;

    /**
     * Создает объект ответа API.
     *
     * @param int $rateLimit
     * @param int $rateLimitRemaining
     */
    public function __construct(int $rateLimit, int $rateLimitRemaining)
    {
        $this->rateLimit = $rateLimit;
        $this->rateLimitRemaining = $rateLimitRemaining;
    }

    /**
     * Сохраняет данные ответа API.
     *
     * @param array $responseData
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    public function setResponseData(array $responseData)
    {
        $this->responseData = $responseData;

        return $this;
    }

    /**
     * Код ответа API.
     *
     * @return int
     */
    public function metaCode(): int
    {
        return array_get($this->responseData, 'meta.code', 500);
    }

    /**
     * Проверяет, имеется ли какая-либо ошибка в ответе API.
     *
     * @return bool
     */
    public function requestFailed(): bool
    {
        return $this->metaCode() !== static::META_CODE_OK || $this->errorType() !== 'OK';
    }

    /**
     * Возвращает тип ошибки API. Если запрос завершился успешно, возвращает "OK".
     *
     * @return string
     */
    public function errorType(): string
    {
        return array_get($this->responseData, 'meta.error_type', 'OK');
    }

    /**
     * Возвращает текст ошибки API. Если запрос завершился успешно, возвращает "OK".
     *
     * @return string
     */
    public function errorMessage(): string
    {
        return array_get($this->responseData, 'meta.error_message', 'OK');
    }

    /**
     * Возвращает полный JSON-ответ от API.
     *
     * @return array
     */
    public function all()
    {
        return $this->responseData;
    }

    /**
     * Возвращает только данные выполненного запроса (без мета-данных и пагинации).
     *
     * @return array
     */
    public function data()
    {
        return array_get($this->responseData, 'data', []);
    }

    /**
     * Возвращает URL следующей страницы.
     *
     * @return string | null
     */
    public function nextPageUrl()
    {
        if ($this->rateLimitReached()) {
            return;
        }

        return array_get($this->responseData, 'pagination.next_url');
    }

    /**
     * Возвращает максимальное количество API-запросов, которое может выполнить текущее приложение.
     *
     * @return int
     */
    public function rateLimit(): int
    {
        return $this->rateLimit;
    }

    /**
     * Возвращает доступное количество API-запросов.
     *
     * @return int
     */
    public function rateLimitRemaining(): int
    {
        return $this->rateLimitRemaining;
    }

    /**
     * Проверяет, достигнуты ли ограничения по вызовам API-запросов.
     *
     * @return bool
     */
    public function rateLimitReached(): bool
    {
        return $this->rateLimitRemaining === 0;
    }
}
