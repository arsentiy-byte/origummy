<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Trait FormatExceptionMessage.
 */
trait FormatExceptionMessage
{
    /**
     * @param \Throwable $exception
     * @return string
     */
    public function formatExceptionMessage(\Throwable $exception): string
    {
        return sprintf('%d %s in %s:%s', $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
    }
}
