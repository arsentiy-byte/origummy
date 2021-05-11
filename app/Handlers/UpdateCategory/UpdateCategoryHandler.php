<?php

declare(strict_types=1);

namespace App\Handlers\UpdateCategory;

use App\Handlers\BaseHandler;
use App\Handlers\UpdateCategory\Pipes\UpdateCategory;
use App\Handlers\UpdateCategory\Pipes\UpdateCategoryImages;

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
