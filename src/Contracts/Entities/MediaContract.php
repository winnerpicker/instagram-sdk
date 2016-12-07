<?php

namespace Winnerpicker\Instagram\Contracts\Entities;

interface MediaContract
{
    /**
     * Возвращает ID медиа-объекта.
     *
     * @return string
     */
    public function id();

    /**
     * Возвращает ID автора текущего медиа-объекта.
     *
     * @return int
     */
    public function authorId();

    /**
     * Возвращает тип медиа-объекта (image или video).
     *
     * @return string
     */
    public function mediaType();

    /**
     * Возвращает количество комментариев к текущему медиа-объекту.
     *
     * @return int
     */
    public function commentsCount(): int;

    /**
     * Возвращает количество отметок "Мне нравится" к текущему медиа-объекту.
     *
     * @return int
     */
    public function likesCount(): int;

    /**
     * Возвращает время публикации медиа-объекта (UNIX Timestamp, UTC).
     *
     * @return int
     */
    public function createdAt(): int;

    /**
     * Возвращает URL медиа-объекта.
     *
     * @return string
     */
    public function link(): string;

    /**
     * Возвращает URL изображения средних размеров.
     *
     * @return string
     */
    public function lowResolutionUrl(): string;

    /**
     * Возвращает URL превью изображения.
     *
     * @return string
     */
    public function thumbnailUrl(): string;

    /**
     * Возвращает URL оригинального изображения.
     *
     * @return string
     */
    public function standardResolutionUrl(): string;

    /**
     * Возвращает URL видеозаписи среднего качества.
     *
     * @return string
     */
    public function lowResolutionVideoUrl(): string;

    /**
     * Возвращает URL видеозаписи наименьшего качества.
     *
     * @return string
     */
    public function lowBandwidthVideoUrl(): string;

    /**
     * Возвращает URL оригинальной видеозаписи.
     *
     * @return string
     */
    public function standardResolutionVideoUrl(): string;

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

    /**
     * Возвращает список хэштегов, прикрепленных к данному медиа-объекту.
     *
     * @return array
     */
    public function tags(): array;

    /**
     * Возвращает количество упомянутых пользователей.
     *
     * @return int
     */
    public function mentionsCount(): int;

    /**
     * Упоминания аккаунтов из текста описания медиа-объектов.
     *
     * @return array
     */
    public function mentions(): array;

    /**
     * Количество пользователей, отмеченных на медиа-объекте.
     *
     * @return int
     */
    public function usersInPhotoCount(): int;

    /**
     * Пользователи, отмеченные на медиа-объекте.
     *
     * @return array
     */
    public function usersInPhoto(): array;

    /**
     * Возвращает количество всех отмеченных пользователей на медиа-объекте.
     * Используются @упоминания из описания медиа-объекта и отмеченные пользователи.
     *
     * @return int
     */
    public function allTaggedUsersCount(): int;

    /**
     * Возвращает список всех отмеченных пользователей на медиа-объекте.
     * Используются @упоминания из описания медиа-объекта и отмеченные пользователи.
     *
     * @return array
     */
    public function allTaggedUsers(): array;
}
