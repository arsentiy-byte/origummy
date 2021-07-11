<?php

declare(strict_types=1);

namespace App\Handlers\Product\DeleteProduct;

use App\Handlers\BaseHandler;
use App\Handlers\Product\DeleteProduct\Pipes\DeleteProduct;
use App\Handlers\Product\DeleteProduct\Pipes\DeleteProductImages;

final class DeleteProductHandler extends BaseHandler
{
    public const PIPES = [
        DeleteProduct::class,
        DeleteProductImages::class,
    ];
}
