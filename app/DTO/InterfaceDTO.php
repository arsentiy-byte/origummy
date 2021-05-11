<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Interface InterfaceDTO.
 */
interface InterfaceDTO
{
    public static function fromArray(array $input): self;
}
