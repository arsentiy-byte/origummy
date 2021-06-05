<?php

declare(strict_types=1);

namespace App\Handlers\Product\UpdateProduct;

use App\Handlers\BaseHandler;
use App\Handlers\Product\UpdateProduct\Pipes\UpdateProduct;
use App\Handlers\Product\UpdateProduct\Pipes\UpdateProductImages;
use App\Handlers\Product\UpdateProduct\Pipes\UpdatePromotionAttachments;
use App\Handlers\Product\UpdateProduct\Pipes\UpdateRelatedProducts;

final class UpdateProductHandler extends BaseHandler
{
    public const PIPES = [
        UpdateProduct::class,
        UpdateProductImages::class,
        UpdateRelatedProducts::class,
        UpdatePromotionAttachments::class,
    ];
}
