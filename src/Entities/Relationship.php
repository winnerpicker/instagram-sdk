<?php

namespace Winnerpicker\Instagram\Entities;

use Winnerpicker\Instagram\Contracts\Entities\RelationshipContract;

class Relationship implements RelationshipContract
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
     * Проверяет, подписан ли текущий пользователь на второго пользователя.
     *
     * @return bool
     */
    public function following(): bool
    {
        return array_get($this->data, 'outgoing_status') === 'follows';
    }

    /**
     * Проверяет, подписан ли второй пользователь на текущего пользователя.
     *
     * @return bool
     */
    public function followedBy(): bool
    {
        return array_get($this->data, 'incoming_status') === 'followed_by';
    }
}
