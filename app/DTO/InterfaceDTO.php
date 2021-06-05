<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Interface InterfaceDTO.
 */
interface InterfaceDTO
{
    /**
     * @param array $input
     * @return static
     */
    public static function fromArray(array $input): self;
}
