<?php

namespace Winnerpicker\Instagram\Contracts;

interface PaginationEndpointContract
{
    /**
     * Индикатор пагинации. Используется в качестве условия для цикла.
     *
     * @return bool
     */
    public function paginate(): bool;

    /**
     * Ответ текущего эндпоинта.
     *
     * @return array
     */
    public function response(): array;
}
