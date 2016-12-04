<?php

namespace Winnerpicker\Instagram\Entities;

use Winnerpicker\Instagram\Contracts\Entities\TagContract;

class Tag implements TagContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Название текущего тега.
     *
     * @return string
     */
    public function name(): string
    {
        return array_get($this->data, 'name');
    }

    /**
     * Возвращает количество медиа-объект, отмеченных текущим тегом.
     *
     * @return int
     */
    public function mediaCount(): int
    {
        return intval(array_get($this->data, 'media_count'));
    }
}
