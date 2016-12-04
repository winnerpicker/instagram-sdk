<?php

namespace Winnerpicker\Instagram\Contracts\Api;

interface ApiResponseContract
{
    /**
     * Сохраняет данные ответа API.
     *
     * @param array $responseData
     *
     * @return \Winnerpicker\Instagram\Contracts\Api\ApiResponseContract
     */
    public function setResponseData(array $responseData);

    /**
     * Код ответа API.
     *
     * @return int
     */
    public function metaCode(): int;

    /**
     * Проверяет, имеется ли какая-либо ошибка в ответе API.
     *
     * @return bool
     */
    public function requestFailed(): bool;

    /**
     * Возвращает тип ошибки API. Если запрос завершился успешно, возвращает "OK".
     *
     * @return string
     */
    public function errorType(): string;

    /**
     * Возвращает текст ошибки API. Если запрос завершился успешно, возвращает "OK".
     *
     * @return string
     */
    public function errorMessage(): string;

    /**
     * Возвращает полный JSON-ответ от API.
     *
     * @return array
     */
    public function all();

    /**
     * Возвращает только данные выполненного запроса (без мета-данных и пагинации).
     *
     * @return array
     */
    public function data();

    /**
     * Возвращает URL следующей страницы.
     *
     * @return string | null
     */
    public function nextPageUrl();

    /**
     * Возвращает максимальное количество API-запросов, которое может выполнить текущее приложение.
     *
     * @return int
     */
    public function rateLimit(): int;

    /**
     * Возвращает доступное количество API-запросов.
     *
     * @return int
     */
    public function rateLimitRemaining(): int;

    /**
     * Проверяет, достигнуты ли ограничения по вызовам API-запросов.
     *
     * @return bool
     */
    public function rateLimitReached(): bool;
}
