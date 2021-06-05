<?php

declare(strict_types=1);

namespace App\Handlers\Category\UpdateCategory;

use App\Handlers\BaseHandler;
use App\Handlers\Category\UpdateCategory\Pipes\UpdateCategory;
use App\Handlers\Category\UpdateCategory\Pipes\UpdateCategoryImages;

/**
 * Class UpdateCategoryHandler.
 */
final class UpdateCategoryHandler extends BaseHandler
{
    public const PIPES = [
        UpdateCategory::class,
        UpdateCategoryImages::class,
    ];
}
