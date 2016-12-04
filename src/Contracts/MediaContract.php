<?php

namespace Winnerpicker\Instagram\Contracts;

interface MediaContract
{
    /**
     * Возвращает ID медиа.
     *
     * @return string
     */
    public function id();

    /**
     * Возвращает URL изображения средних размеров.
     *
     * @return string
     */
    public function lowResolutionUrl(): string;

    /**
     * Возвращает авторский комментарий (описание) к медиа-объекту.
     *
     * @return string
     */
    public function captionText(): string;

    /**
     * Возвращает количество хэштегов, прикрепленных к данному медиа-объекту.
     *
     * @return int
     */
    public function tagsCount(): int;
}
