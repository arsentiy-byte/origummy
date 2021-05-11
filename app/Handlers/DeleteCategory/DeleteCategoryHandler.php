<?php

declare(strict_types=1);

namespace App\Handlers\DeleteCategory;

use App\Handlers\BaseHandler;
use App\Handlers\DeleteCategory\Pipes\DeleteCategory;
use App\Handlers\DeleteCategory\Pipes\DeleteCategoryImages;

/**
 * Class DeleteCategoryHandler.
 */
final class DeleteCategoryHandler extends BaseHandler
{
    public const PIPES = [
        DeleteCategoryImages::class,
        DeleteCategory::class,
    ];
}
