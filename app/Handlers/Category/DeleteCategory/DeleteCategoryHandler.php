<?php

declare(strict_types=1);

namespace App\Handlers\Category\DeleteCategory;

use App\Handlers\BaseHandler;
use App\Handlers\Category\DeleteCategory\Pipes\DeleteCategory;
use App\Handlers\Category\DeleteCategory\Pipes\DeleteCategoryImages;

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
