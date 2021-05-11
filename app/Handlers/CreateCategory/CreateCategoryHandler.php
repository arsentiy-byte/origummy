<?php

declare(strict_types=1);

namespace App\Handlers\CreateCategory;

use App\Handlers\BaseHandler;
use App\Handlers\CreateCategory\Pipes\CreateCategory;
use App\Handlers\CreateCategory\Pipes\CreateCategoryImages;

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
