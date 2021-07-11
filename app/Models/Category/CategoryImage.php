<?php

declare(strict_types=1);

namespace App\Models\Category;

use App\Models\BaseModel;

/**
 * Class CategoryImage.
 * @property int $category_id
 * @property string $path
 */
final class CategoryImage extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'categories_images';

    /**
     * @var string[]
     */
    protected $fillable = [
        'category_id', 'path',
    ];
}
