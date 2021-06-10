<?php

declare(strict_types=1);

namespace App\Services\Notifications;

/**
 * Interface GetMessageInterface.
 */
interface GetMessageInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;
}
