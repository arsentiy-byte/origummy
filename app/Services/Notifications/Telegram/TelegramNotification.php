<?php

declare(strict_types=1);

namespace App\Services\Notifications\Telegram;

use App\Services\Notifications\BaseNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

/**
 * Class TelegramNotification.
 */
final class TelegramNotification extends BaseNotification
{
    protected const CHANNEL = 'telegram';
    protected const ROUTES = [
        '428874805',
        '1365011967',
    ];

    /**
     * @param Notification $notification
     */
    public static function send(Notification $notification): void
    {
        foreach (self::ROUTES as $route) {
            NotificationFacade::route(self::CHANNEL, $route)
                ->notify($notification);
        }
    }
}
