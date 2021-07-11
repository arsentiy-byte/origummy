<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\CreatePromotion;

use App\Handlers\BaseHandler;
use App\Handlers\Promotion\CreatePromotion\Pipes\CreatePromotion;
use App\Handlers\Promotion\CreatePromotion\Pipes\CreateRelatedPromotion;

/**
 * Class CreatePromotionHandler.
 */
final class CreatePromotionHandler extends BaseHandler
{
    public const PIPES = [
        CreatePromotion::class,
        CreateRelatedPromotion::class,
    ];
}
