<?php

declare(strict_types=1);

namespace Tests\TestCase;

use Tests\TestCase;

/**
 * Class ApiTestCase.
 */
abstract class ApiTestCase extends TestCase
{
    /**
     * @param array $data
     * @return array
     */
    public function resourceStructure(array $data): array
    {
        $template = [
            'error_code',
            'status',
            'message',
            'data' => [],
        ];

        $template['data'] = array_merge($template['data'], $data);

        return $template;
    }
}
