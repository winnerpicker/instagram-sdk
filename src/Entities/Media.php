<?php

namespace Winnerpicker\Instagram\Entities;

use Winnerpicker\Instagram\Contracts\Entities\MediaContract;

class Media implements MediaContract
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
     * Возвращает ID медиа-объекта.
     *
     * @return string | null
     */
    public function id()
    {
        return array_get($this->data, 'id');
    }

    /**
     * Возвращает ID автора текущего медиа-объекта.
     *
     * @return int
     */
    public function authorId()
    {
        return array_get($this->data, 'user.id');
    }

    /**
     * Возвращает тип медиа-объекта (image или video).
     *
     * @return string
     */
    public function mediaType()
    {
        return array_get($this->data, 'type');
    }

    /**
     * Возвращает количество комментариев к текущему медиа-объекту.
     *
     * @return int
     */
    public function commentsCount(): int
    {
        return intval(array_get($this->data, 'comments.count'));
    }

    /**
     * Возвращает количество отметок "Мне нравится" к текущему медиа-объекту.
     *
     * @return int
     */
    public function likesCount(): int
    {
        return intval(array_get($this->data, 'likes.count'));
    }

    /**
     * Возвращает время публикации медиа-объекта (UNIX Timestamp, UTC).
     *
     * @return int
     */
    public function createdAt(): int
    {
        return intval(array_get($this->data, 'created_time'));
    }

    /**
     * Возвращает URL медиа-объекта.
     *
     * @return string
     */
    public function link(): string
    {
        return array_get($this->data, 'link', '');
    }

    /**
     * Возвращает URL изображения средних размеров.
     *
     * @return string
     */
    public function lowResolutionUrl(): string
    {
        return array_get($this->data, 'images.low_resolution.url');
    }

    /**
     * Возвращает URL превью изображения.
     *
     * @return string
     */
    public function thumbnailUrl(): string
    {
        return array_get($this->data, 'images.thumbnail.url');
    }

    /**
     * Возвращает URL оригинального изображения.
     *
     * @return string
     */
    public function standardResolutionUrl(): string
    {
        return array_get($this->data, 'images.standard_resolution.url');
    }

    /**
     * Возвращает URL видеозаписи среднего качества.
     *
     * @return string
     */
    public function lowResolutionVideoUrl(): string
    {
        return array_get($this->data, 'videos.low_resolution.url');
    }

    /**
     * Возвращает URL видеозаписи наименьшего качества.
     *
     * @return string
     */
    public function lowBandwidthVideoUrl(): string
    {
        return array_get($this->data, 'videos.low_bandwidth.url');
    }

    /**
     * Возвращает URL оригинальной видеозаписи.
     *
     * @return string
     */
    public function standardResolutionVideoUrl(): string
    {
        return array_get($this->data, 'videos.standard_resolution.url');
    }

    /**
     * Возвращает авторский комментарий (описание) к медиа-объекту.
     *
     * @return string
     */
    public function captionText(): string
    {
        return array_get($this->data, 'caption.text', '');
    }

    /**
     * Возвращает количество хэштегов, прикрепленных к данному медиа-объекту.
     *
     * @return int
     */
    public function tagsCount(): int
    {
        return count($this->tags());
    }

    /**
     * Возвращает список хэштегов, прикрепленных к данному медиа-объекту.
     *
     * @return array
     */
    public function tags(): array
    {
        return array_get($this->data, 'tags', []);
    }

    /**
     * Возвращает количество упомянутых пользователей.
     *
     * @return int
     */
    public function mentionsCount(): int
    {
        return count($this->mentions());
    }

    /**
     * Упоминания аккаунтов из текста описания медиа-объектов.
     *
     * @return array
     */
    public function mentions(): array
    {
        $parsed = array_get($this->data, 'parsed_mentions');

        if (!is_null($parsed)) {
            return $parsed;
        }

        $caption = $this->captionText();
        $matches = [];

        if (!preg_match_all('/(@\w+)/', $this->captionText(), $matches)) {
            return $this->data['parsed_mentions'] = [];
        }

        $mentions = collect($matches[0])
            ->map(function ($mention) {
                return trim(strtolower(str_replace('@', '', $mention)));
            })
            ->toArray();

        return $this->data['parsed_mentions'] = $mentions;
    }

    /**
     * Количество пользователей, отмеченных на медиа-объекте.
     *
     * @return int
     */
    public function usersInPhotoCount(): int
    {
        return count($this->usersInPhoto());
    }

    /**
     * Пользователи, отмеченные на медиа-объекте.
     *
     * @return array
     */
    public function usersInPhoto(): array
    {
        $mapped = array_get($this->data, 'mapped_users_in_photo');

        if (!is_null($mapped)) {
            return $mapped;
        }

        return $this->data['mapped_users_in_photo'] = collect(array_get($this->data, 'users_in_photo', []))
            ->map(function ($user) {
                return array_get($user, 'user.username');
            })
            ->reject(null)
            ->toArray();
    }

    /**
     * Возвращает количество всех отмеченных пользователей на медиа-объекте.
     * Используются @упоминания из описания медиа-объекта и отмеченные пользователи.
     *
     * @return int
     */
    public function allTaggedUsersCount(): int
    {
        return count($this->allTaggedUsers());
    }

    /**
     * Возвращает список всех отмеченных пользователей на медиа-объекте.
     * Используются @упоминания из описания медиа-объекта и отмеченные пользователи.
     *
     * @return array
     */
    public function allTaggedUsers(): array
    {
        return array_merge($this->mentions(), $this->usersInPhoto());
    }
}
