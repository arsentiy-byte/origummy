<?php

declare(strict_types=1);

namespace App\Handlers\Category\CreateCategory;

use App\Handlers\BaseHandler;
use App\Handlers\Category\CreateCategory\Pipes\CreateCategory;
use App\Handlers\Category\CreateCategory\Pipes\CreateCategoryImages;

/**
 * Class CreateCategoryHandler.
 */
final class CreateCategoryHandler extends BaseHandler
{
    public const PIPES = [
        CreateCategory::class,
        CreateCategoryImages::class,
    ];
}
