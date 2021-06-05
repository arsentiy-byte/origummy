<?php

declare(strict_types=1);

namespace App\Handlers\Product\CreateProduct;

use App\Handlers\BaseHandler;
use App\Handlers\Product\CreateProduct\Pipes\AttachPromotions;
use App\Handlers\Product\CreateProduct\Pipes\CreateProduct;
use App\Handlers\Product\CreateProduct\Pipes\CreateProductImages;
use App\Handlers\Product\CreateProduct\Pipes\CreateRelatedProducts;

/**
 * Class CreateProductHandler.
 */
final class CreateProductHandler extends BaseHandler
{
    public const PIPES = [
        CreateProduct::class,
        CreateProductImages::class,
        CreateRelatedProducts::class,
        AttachPromotions::class,
    ];
}
