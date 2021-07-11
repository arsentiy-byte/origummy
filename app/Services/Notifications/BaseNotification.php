<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use Illuminate\Notifications\Notification;

/**
 * Class BaseNotification.
 */
abstract class BaseNotification
{
    protected const CHANNEL = 'default';
    protected const ROUTES = [];

    /**
     * @param Notification $notification
     */
    abstract public static function send(Notification $notification): void;
}
