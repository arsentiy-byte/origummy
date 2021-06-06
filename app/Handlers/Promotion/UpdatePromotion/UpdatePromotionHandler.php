<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\UpdatePromotion;

use App\Handlers\BaseHandler;
use App\Handlers\Promotion\UpdatePromotion\Pipes\UpdatePromotion;
use App\Handlers\Promotion\UpdatePromotion\Pipes\UpdateRelatedPromotion;

/**
 * Class UpdatePromotionHandler.
 */
final class UpdatePromotionHandler extends BaseHandler
{
    public const PIPES = [
        UpdatePromotion::class,
        UpdateRelatedPromotion::class,
    ];
}
