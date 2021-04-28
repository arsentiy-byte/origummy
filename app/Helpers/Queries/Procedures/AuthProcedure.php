<?php

declare(strict_types=1);

namespace App\Helpers\Queries\Procedures;

use PDO;

/**
 * Class AuthProcedure.
 */
final class AuthProcedure extends BaseProcedure
{
    /**
     * @param array $params
     * @return void
     */
    protected function setParams(array $params): void
    {
        $this->params = [
            'pUname' => ['value' => $params['username']],
            'pPSW' => ['value' => $params['password']],
            'pUserIP' => ['value' => $params['REMOTE_ADDR']],
            'pDeviceInfo' => ['value' => $params['HTTP_USER_AGENT']],
            'pIsVerified' => ['value' => 0, 'isOut' => true, 'type' => PDO::PARAM_INT],
            'pRes' => ['value' => 0, 'isOut' => true, 'type' => PDO::PARAM_INT],
        ];
    }
}
