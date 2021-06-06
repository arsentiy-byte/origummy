<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\DeletePromotion;

use App\Handlers\BaseHandler;
use App\Handlers\Promotion\DeletePromotion\Pipes\DeletePromotion;

/**
 * Class DeletePromotionHandler.
 */
final class DeletePromotionHandler extends BaseHandler
{
    public const PIPES = [
        DeletePromotion::class,
    ];
}
