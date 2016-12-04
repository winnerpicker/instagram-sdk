<?php

namespace Winnerpicker\Instagram\Contracts;

interface RelationshipStatusContract
{
    /**
     * Проверяет, подписан ли текущий пользователь на второго пользователя.
     *
     * @return bool
     */
    public function following(): bool;

    /**
     * Проверяет, подписан ли второй пользователь на текущего пользователя.
     *
     * @return bool
     */
    public function followedBy(): bool;
}
