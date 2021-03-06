<?php

namespace Winnerpicker\Instagram\Contracts\Entities;

interface TagContract
{
    /**
     * Название текущего тега.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Возвращает количество медиа-объект, отмеченных текущим тегом.
     *
     * @return int
     */
    public function mediaCount(): int;
}
